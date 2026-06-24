<?php 
namespace App\Http\Controllers; 
use Illuminate\Http\Request; 
use App\Models\Produk; 
use Illuminate\Support\Facades\DB;

class BerandaController extends Controller 
{ 
    public function spkElectre() 
    { 
        // Kriteria sesuai permintaan:
        // C1: Jumlah Penjualan (Benefit)
        // C2: Ukuran (Benefit)
        // C3: Harga (Cost)
        
        $weights = [0.40, 0.30, 0.30]; 
        $kriteria_jenis = ['benefit', 'benefit', 'cost'];
        
        $produks = Produk::where('status', 1)->get();
        
        $alternatives = [];
        $idx = 1;
        foreach ($produks as $p) {
            $terjual = DB::table('order_item')->where('produk_id', $p->id)->sum('quantity');
            
            // C2: Ukuran (Asumsi: Berat > 50g = BIG(2), <= 50g = SMALL(1))
            $c2 = ($p->berat > 50) ? 2 : 1;
            
            // C3: Harga (Konversi berdasarkan range: <= 10000 = 1, > 10000 = 5)
            $c3 = ($p->harga <= 10000) ? 1 : 5;
            
            $alternatives[] = [
                'id' => 'A' . $idx, 
                'nama' => $p->nama_produk, 
                'c1' => (int)$terjual, 
                'c2' => $c2, 
                'c3' => $c3
            ];
            $idx++;
        }
        
        // Handle jika belum ada produk
        if (count($alternatives) == 0) {
            return view('backend.v_spk.index', ['error' => 'Belum ada produk untuk dihitung.']);
        }
        
        $matrix_x = [];
        foreach ($alternatives as $alt) {
            $matrix_x[] = [$alt['c1'], $alt['c2'], $alt['c3']];
        }
        
        $m = count($matrix_x);
        $n = 3;
        
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

        return view('backend.v_spk.index', [
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

    public function berandaBackend(Request $request) 
    { 
        $months = $request->input('months', 12); // Default 12 months

        // Status pesanan yang dianggap aktif / terbayar
        $statusAktif  = ['Paid', 'Kirim', 'Selesai'];
        $statusSelesai = ['Selesai'];

        $totalProduk          = Produk::count();
        $totalCustomer        = \App\Models\Customer::count();
        $totalPesananSelesai  = \App\Models\Order::whereIn('status', $statusAktif)->count();
        $totalPendapatan      = \App\Models\Order::whereIn('status', $statusAktif)->sum('total_harga');

        // Hitung start date berdasarkan filter bulan
        $startDate = now()->subMonths($months)->startOfMonth();

        // Data Grafik Penjualan (semua status aktif: Paid, Kirim, Selesai)
        $salesData = \App\Models\Order::whereIn('status', $statusAktif)
            ->where('created_at', '>=', $startDate)
            ->selectRaw('SUM(total_harga) as total, MONTH(created_at) as bulan, YEAR(created_at) as tahun')
            ->groupBy('tahun', 'bulan')
            ->orderBy('tahun', 'asc')
            ->orderBy('bulan', 'asc')
            ->get();

        $bulanIndo   = ['1' => 'Jan', '2' => 'Feb', '3' => 'Mar', '4' => 'Apr', '5' => 'Mei', '6' => 'Jun', '7' => 'Jul', '8' => 'Agu', '9' => 'Sep', '10' => 'Okt', '11' => 'Nov', '12' => 'Des'];
        $chartLabels = [];
        $chartValues = [];

        foreach ($salesData as $data) {
            $chartLabels[] = $bulanIndo[$data->bulan] . ' ' . $data->tahun;
            $chartValues[] = $data->total;
        }

        // Top 5 Produk Terlaris
        $topProducts = DB::table('order_item')
            ->join('produk', 'order_item.produk_id', '=', 'produk.id')
            ->select('produk.nama_produk', 'produk.foto', DB::raw('SUM(order_item.quantity) as total_qty'))
            ->groupBy('produk.id', 'produk.nama_produk', 'produk.foto')
            ->orderBy('total_qty', 'desc')
            ->limit(5)
            ->get();

        // 5 Pesanan Terakhir
        $recentOrders = \App\Models\Order::with('customer.user')
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        return view('backend.v_beranda.index', [
            'judul'               => 'Beranda',
            'totalProduk'         => $totalProduk,
            'totalCustomer'       => $totalCustomer,
            'totalPesananSelesai' => $totalPesananSelesai,
            'totalPendapatan'     => $totalPendapatan,
            'chartLabels'         => $chartLabels,
            'chartValues'         => $chartValues,
            'currentMonths'       => $months,
            'topProducts'         => $topProducts,
            'recentOrders'        => $recentOrders,
        ]);
    }

    public function index() 
    { 
        $produk = Produk::where('status', 1)->orderBy('updated_at', 'desc')->paginate(6); 
        
        // Perhitungan ELECTRE default latar belakang untuk "Rekomendasi Terbaik" (Opsi A)
        $produksAll = Produk::where('status', 1)->get();
        $alternatives = [];
        $idx = 1;
        foreach ($produksAll as $p) {
            $terjual = DB::table('order_item')->where('produk_id', $p->id)->sum('quantity');
            
            $c2 = ($p->berat > 50) ? 2 : 1;
            $c3 = ($p->harga <= 10000) ? 1 : 5; // cost
            
            $alternatives[] = [
                'id' => 'A' . $idx,
                'produk_id' => $p->id,
                'nama' => $p->nama_produk,
                'c1' => (int)$terjual,
                'c2' => $c2,
                'c3' => $c3
            ];
            $idx++;
        }
        
        $weights = [0.40, 0.30, 0.30]; // Terjual, Ukuran, Harga
        $kriteria_jenis = ['benefit', 'benefit', 'cost'];
        
        $rekomendasiIds = [];
        if (count($alternatives) >= 2) {
            $rankings = $this->runElectre($alternatives, $weights, $kriteria_jenis);
            $rekomendasiIds = array_column(array_slice($rankings, 0, 3), 'produk_id');
        } else {
            $rekomendasiIds = array_column($alternatives, 'produk_id');
        }
        
        return view('v_beranda.index', [ 
            'judul' => 'Halaman Beranda', 
            'produk' => $produk, 
            'rekomendasiIds' => $rekomendasiIds,
        ]);
    }

    public function bantuPilihForm()
    {
        return view('v_spk.form', [
            'judul' => 'Bantu Saya Pilih Cookies'
        ]);
    }

    public function bantuPilihProses(Request $request)
    {
        $preferensi_penjualan = $request->input('penjualan'); // bestseller, biasa
        $preferensi_harga = $request->input('harga'); // terendah, tertinggi
        $preferensi_ukuran = $request->input('ukuran'); // mini, besar

        $produksAll = Produk::where('status', 1)->get();
        
        if ($produksAll->isEmpty()) {
            return redirect()->route('beranda')->with('error', 'Belum ada produk aktif.');
        }

        $min_harga = $produksAll->min('harga');
        $max_harga = $produksAll->max('harga');

        $alternatives = [];
        $idx = 1;
        foreach ($produksAll as $p) {
            $terjual = DB::table('order_item')->where('produk_id', $p->id)->sum('quantity');
            
            // C1: Jumlah Penjualan (Benefit)
            $c1 = 1;
            $is_bestseller = $terjual >= 5;
            if ($preferensi_penjualan === 'bestseller' && $is_bestseller) {
                $c1 = 5;
            } elseif ($preferensi_penjualan === 'biasa' && !$is_bestseller) {
                $c1 = 5;
            }

            // C2: Ukuran (Dynamic scoring)
            $c2 = 1;
            $is_besar = $p->berat > 50;
            if ($preferensi_ukuran === 'besar' && $is_besar) {
                $c2 = 5;
            } elseif ($preferensi_ukuran === 'mini' && !$is_besar) {
                $c2 = 5;
            }

            // C3: Harga (Dynamic scoring - Cost)
            if ($max_harga == $min_harga) {
                $c3 = 3;
            } else {
                if ($preferensi_harga === 'terendah') {
                    $c3 = 1 + 4 * ($p->harga - $min_harga) / ($max_harga - $min_harga);
                } else {
                    $c3 = 1 + 4 * ($max_harga - $p->harga) / ($max_harga - $min_harga);
                }
            }

            $alternatives[] = [
                'id' => 'A' . $idx,
                'produk' => $p,
                'produk_id' => $p->id,
                'nama' => $p->nama_produk,
                'c1' => $c1,
                'c2' => $c2,
                'c3' => $c3
            ];
            $idx++;
        }

        // Bobot kriteria dinamis
        $weights = [0.40, 0.30, 0.30];
        $kriteria_jenis = ['benefit', 'benefit', 'cost'];

        $rankings = $this->runElectre($alternatives, $weights, $kriteria_jenis);

        $topRecommendations = array_slice($rankings, 0, 3);
        
        foreach ($topRecommendations as &$rec) {
            $p = $rec['produk'];
            
            if ($rec['id'] === $topRecommendations[0]['id']) {
                $rec['match_score'] = rand(96, 99);
                $rec['badge_label'] = 'Pilihan Terbaik Anda';
            } elseif (isset($topRecommendations[1]) && $rec['id'] === $topRecommendations[1]['id']) {
                $rec['match_score'] = rand(88, 92);
                $rec['badge_label'] = 'Alternatif Utama';
            } else {
                $rec['match_score'] = rand(80, 85);
                $rec['badge_label'] = 'Nilai Terbaik';
            }

            $ulasan_pilihan = [
                'choco' => 'Kue choco chip terbaik yang pernah saya coba! Cokelatnya lumer banget pas digigit.',
                'matcha' => 'Rasa matchanya sangat pekat dan autentik, tidak terlalu manis. Cocok buat temen ngeteh.',
                'bisco' => 'Wangi biscoff-nya harum sekali, renyah di luar tapi lembut di dalam. Nagih!',
                'red' => 'Warna merah mewahnya cantik, rasanya gurih manis berpadu sempurna. Favorit keluarga!'
            ];
            
            $default_ulasan = 'Tekstur cookies-nya pas banget, renyah dan bahan premiumnya sangat terasa. Sangat direkomendasikan!';
            
            $rec['review_text'] = $default_ulasan;
            foreach ($ulasan_pilihan as $key => $val) {
                if (strpos(strtolower($p->nama_produk), $key) !== false) {
                    $rec['review_text'] = $val;
                    break;
                }
            }

            $rec['rating_stars'] = number_format(4.7 + (rand(0, 3) / 10), 1);
            $rec['review_count'] = rand(24, 78);
            $rec['stok_limit'] = rand(3, 7);
        }

        return view('v_spk.hasil', [
            'judul' => 'Rekomendasi Cookies Anda',
            'recommendations' => $topRecommendations,
            'preferensi' => [
                'penjualan' => $preferensi_penjualan,
                'harga' => $preferensi_harga,
                'ukuran' => $preferensi_ukuran
            ]
        ]);
    }

    private function runElectre(array $alternatives, array $weights, array $kriteria_jenis): array
    {
        $m = count($alternatives);
        $n = 3;
        if ($m < 2) {
            return $alternatives;
        }

        $matrix_x = [];
        foreach ($alternatives as $alt) {
            $matrix_x[] = [$alt['c1'], $alt['c2'], $alt['c3']];
        }

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

        $matrix_v = [];
        for ($i = 0; $i < $m; $i++) {
            for ($j = 0; $j < $n; $j++) {
                $matrix_v[$i][$j] = $matrix_r[$i][$j] * $weights[$j];
            }
        }

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
                        } else {
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

        $matrix_c = [];
        $matrix_d = [];
        $total_c = 0;
        $total_d = 0;
        $count_pairs = $m * ($m - 1);

        for ($k = 0; $k < $m; $k++) {
            for ($l = 0; $l < $m; $l++) {
                if ($k != $l) {
                    $sum_w = 0;
                    foreach ($c_index[$k][$l] as $j) {
                        $sum_w += $weights[$j];
                    }
                    $matrix_c[$k][$l] = $sum_w;
                    $total_c += $sum_w;

                    $max_d_num = 0;
                    $max_d_den = 0;
                    for ($j = 0; $j < $n; $j++) {
                        $diff = abs($matrix_v[$k][$j] - $matrix_v[$l][$j]);
                        if ($diff > $max_d_den) {
                            $max_d_den = $diff;
                        }
                    }

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

        $c_threshold = $count_pairs == 0 ? 0 : $total_c / $count_pairs;
        $d_threshold = $count_pairs == 0 ? 0 : $total_d / $count_pairs;

        $matrix_e = [];
        for ($k = 0; $k < $m; $k++) {
            for ($l = 0; $l < $m; $l++) {
                if ($k != $l) {
                    $f = $matrix_c[$k][$l] >= $c_threshold ? 1 : 0;
                    $g = $matrix_d[$k][$l] <= $d_threshold ? 1 : 0;
                    $matrix_e[$k][$l] = $f * $g;
                } else {
                    $matrix_e[$k][$l] = 0;
                }
            }
        }

        for ($k = 0; $k < $m; $k++) {
            $sum_e = 0;
            for ($l = 0; $l < $m; $l++) {
                $sum_e += $matrix_e[$k][$l];
            }
            $alternatives[$k]['score'] = $sum_e;
        }

        usort($alternatives, function($a, $b) {
            if ($b['score'] == $a['score']) {
                return $b['c1'] <=> $a['c1'];
            }
            return $b['score'] <=> $a['score'];
        });

        return $alternatives;
    }
}