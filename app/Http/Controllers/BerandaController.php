<?php 
namespace App\Http\Controllers; 
use Illuminate\Http\Request; 
use App\Models\Produk; 
use Illuminate\Support\Facades\DB;

class BerandaController extends Controller 
{ 
    public function berandaBackend() 
    { 
        // Kriteria sesuai permintaan:
        // C1: Varian Rasa (Benefit)
        // C2: Ukuran (Benefit)
        // C3: Harga (Cost)
        // C4: Jumlah Terjual (Benefit)
        
        $weights = [0.35, 0.25, 0.20, 0.20]; // Total bobot sekarang pas 1.0
        $kriteria_jenis = ['benefit', 'benefit', 'cost', 'benefit'];
        
        $produks = Produk::where('status', 1)->get();
        
        $alternatives = [];
        $idx = 1;
        foreach ($produks as $p) {
            // C4: Jumlah Terjual (Real-time dari database)
            $terjual = DB::table('order_item')->where('produk_id', $p->id)->sum('quantity');
            
            // C1: Varian Rasa (Simulasi skor berdasarkan nama produk menyerupai Excel)
            $nama_lower = strtolower($p->nama_produk);
            $c1 = 3; // default
            if (strpos($nama_lower, 'choco') !== false || strpos($nama_lower, 'c.c') !== false) $c1 = 4;
            elseif (strpos($nama_lower, 'red') !== false) $c1 = 2;
            elseif (strpos($nama_lower, 'matcha') !== false || strpos($nama_lower, 'mat') !== false) $c1 = 3;
            elseif (strpos($nama_lower, 'biscoff') !== false || strpos($nama_lower, 'bis') !== false) $c1 = 1;
            
            // C2: Ukuran (Asumsi: Berat > 300g = BIG(2), <= 300g = SMALL(1))
            $c2 = ($p->berat > 300) ? 2 : 1;
            
            // C3: Harga (Konversi berdasarkan range: <= 10000 = 1, > 10000 = 5)
            $c3 = ($p->harga <= 10000) ? 1 : 5;
            
            $alternatives[] = [
                'id' => 'A' . $idx, 
                'nama' => $p->nama_produk, 
                'c1' => $c1, 
                'c2' => $c2, 
                'c3' => $c3, 
                'c4' => (int)$terjual
            ];
            $idx++;
        }
        
        // Handle jika belum ada produk
        if (count($alternatives) == 0) {
            return view('backend.v_beranda.index', ['error' => 'Belum ada produk untuk dihitung.']);
        }
        
        $matrix_x = [];
        foreach ($alternatives as $alt) {
            $matrix_x[] = [$alt['c1'], $alt['c2'], $alt['c3'], $alt['c4']];
        }
        
        $m = count($matrix_x); // number of alternatives = 4
        $n = 4; // number of criteria = 4
        
        // 1. Normalisasi Matriks (R)
        $pembagi = [];
        for ($j = 0; $j < $n; $j++) {
            $sum_sq = 0;
            for ($i = 0; $i < $m; $i++) {
                $sum_sq += pow($matrix_x[$i][$j], 2);
            }
            $pembagi[$j] = sqrt($sum_sq);
        }
        
        $matrix_r = [];
        for ($i = 0; $i < $m; $i++) {
            for ($j = 0; $j < $n; $j++) {
                $matrix_r[$i][$j] = $pembagi[$j] == 0 ? 0 : ($matrix_x[$i][$j] / $pembagi[$j]);
            }
        }
        
        // 2. Matriks Normalisasi Terbobot (V)
        $matrix_v = [];
        for ($i = 0; $i < $m; $i++) {
            for ($j = 0; $j < $n; $j++) {
                $matrix_v[$i][$j] = $matrix_r[$i][$j] * $weights[$j];
            }
        }
        
        // 3. Concordance (C) & Discordance (D) Index
        $c_index = [];
        $d_index = [];
        
        for ($k = 0; $k < $m; $k++) {
            for ($l = 0; $l < $m; $l++) {
                if ($k != $l) {
                    $c_index[$k][$l] = [];
                    $d_index[$k][$l] = [];
                    for ($j = 0; $j < $n; $j++) {
                        if ($kriteria_jenis[$j] == 'benefit') {
                            if ($matrix_v[$k][$j] >= $matrix_v[$l][$j]) {
                                $c_index[$k][$l][] = $j;
                            } else {
                                $d_index[$k][$l][] = $j;
                            }
                        } else { // Cost
                            if ($matrix_v[$k][$j] <= $matrix_v[$l][$j]) {
                                $c_index[$k][$l][] = $j;
                            } else {
                                $d_index[$k][$l][] = $j;
                            }
                        }
                    }
                }
            }
        }
        
        // 4. Concordance & Discordance Matrix
        $matrix_c = [];
        $matrix_d = [];
        
        $total_c = 0;
        $total_d = 0;
        $count_pairs = $m * ($m - 1);
        
        for ($k = 0; $k < $m; $k++) {
            for ($l = 0; $l < $m; $l++) {
                if ($k != $l) {
                    // Concordance matrix element
                    $sum_w = 0;
                    foreach ($c_index[$k][$l] as $j) {
                        $sum_w += $weights[$j];
                    }
                    $matrix_c[$k][$l] = $sum_w;
                    $total_c += $sum_w;
                    
                    // Discordance matrix element
                    $max_d_num = 0;
                    $max_d_den = 0;
                    
                    // Denominator is max of ALL j
                    for ($j = 0; $j < $n; $j++) {
                        $diff = abs($matrix_v[$k][$j] - $matrix_v[$l][$j]);
                        if ($diff > $max_d_den) {
                            $max_d_den = $diff;
                        }
                    }
                    
                    // Numerator is max of j in Discordance set
                    foreach ($d_index[$k][$l] as $j) {
                        $diff = abs($matrix_v[$k][$j] - $matrix_v[$l][$j]);
                        if ($diff > $max_d_num) {
                            $max_d_num = $diff;
                        }
                    }
                    
                    $matrix_d[$k][$l] = $max_d_den == 0 ? 0 : ($max_d_num / $max_d_den);
                    $total_d += $matrix_d[$k][$l];
                } else {
                    $matrix_c[$k][$l] = 0; 
                    $matrix_d[$k][$l] = 0;
                }
            }
        }
        
        // 5. Thresholds
        $c_threshold = $count_pairs == 0 ? 0 : $total_c / $count_pairs;
        $d_threshold = $count_pairs == 0 ? 0 : $total_d / $count_pairs;
        
        // 6. Dominance Matrices F and G
        $matrix_f = [];
        $matrix_g = [];
        $matrix_e = [];
        
        for ($k = 0; $k < $m; $k++) {
            for ($l = 0; $l < $m; $l++) {
                if ($k != $l) {
                    $matrix_f[$k][$l] = $matrix_c[$k][$l] >= $c_threshold ? 1 : 0;
                    $matrix_g[$k][$l] = $matrix_d[$k][$l] <= $d_threshold ? 1 : 0; // Less than for discordance dominance
                    
                    // Aggregate dominance matrix
                    $matrix_e[$k][$l] = $matrix_f[$k][$l] * $matrix_g[$k][$l];
                } else {
                    $matrix_f[$k][$l] = 0;
                    $matrix_g[$k][$l] = 0;
                    $matrix_e[$k][$l] = 0;
                }
            }
        }
        
        // 7. Ranking (Row sums of Matrix E)
        $rankings = [];
        for ($k = 0; $k < $m; $k++) {
            $sum_e = 0;
            for ($l = 0; $l < $m; $l++) {
                $sum_e += $matrix_e[$k][$l];
            }
            $alternatives[$k]['score'] = $sum_e;
            $rankings[] = $alternatives[$k];
        }
        
        // Sort descending by score
        usort($rankings, function($a, $b) {
            return $b['score'] <=> $a['score'];
        });

        return view('backend.v_beranda.index', [
            'judul' => 'SPK Produk Terlaris',
            'sub' => 'Metode ELECTRE',
            'alternatives' => $alternatives,
            'weights' => $weights,
            'matrix_x' => $matrix_x,
            'matrix_r' => $matrix_r,
            'matrix_v' => $matrix_v,
            'matrix_c' => $matrix_c,
            'matrix_d' => $matrix_d,
            'matrix_e' => $matrix_e,
            'c_threshold' => $c_threshold,
            'd_threshold' => $d_threshold,
            'rankings' => $rankings
        ]);
    } 

    public function index() 
    { 
        $produk = Produk::where('status', 1)->orderBy('updated_at', 'desc')->paginate(6); 
        return view('v_beranda.index', [ 
            'judul' => 'Halan Beranda', 
            'produk' => $produk, 
        ]); 
    } 
}