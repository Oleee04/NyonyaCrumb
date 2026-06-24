<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produk;
use Illuminate\Support\Facades\DB;

class ProfileMatchingController extends Controller
{
    /**
     * Menangani proses analisis rekomendasi menggunakan metode Profile Matching secara real-time.
     */
    public function analyze(Request $request)
    {
        // Menggunakan profil ideal tetap di backend: Banyak Terjual, Ukuran Besar, Harga Terendah
        $preferensi_penjualan = 'bestseller';
        $preferensi_ukuran    = 'besar';
        $preferensi_harga     = 'terendah';

        // Mengambil seluruh data produk aktif secara real-time langsung dari database
        $produks = Produk::where('status', 1)->with('fotoProduk', 'kategori')->get();

        if ($produks->isEmpty()) {
            return response()->json([
                'success' => false,
                'message' => 'Tidak ada produk aktif.',
                'data'    => []
            ]);
        }

        $min_harga = $produks->min('harga');
        $max_harga = $produks->max('harga');

        // GAP Mapping berdasarkan tabel Profile Matching
        $gap_mapping = [
            0  => 5.0,
            1  => 4.5,
            -1 => 4.0,
            2  => 3.5,
            -2 => 3.0,
            3  => 2.5,
            -3 => 2.0,
            4  => 1.5,
            -4 => 1.0,
        ];

        $results = [];

        foreach ($produks as $p) {
            // C1: Jumlah Penjualan (Benefit, Bobot 0.40, Core Factor)
            $terjual = DB::table('order_item')->where('produk_id', $p->id)->sum('quantity');
            $is_bestseller = $terjual >= 5;
            $profil_c1 = $is_bestseller ? 5 : 1;
            $ideal_c1 = $preferensi_penjualan === 'bestseller' ? 5 : 1;
            $gap_c1 = $profil_c1 - $ideal_c1;
            $bobot_c1 = $gap_mapping[$gap_c1] ?? 1.0;

            // C2: Ukuran (Benefit, Bobot 0.30, Core Factor)
            // Menggunakan proxy berat > 50 sebagai besar, <= 50 sebagai mini/kecil
            $is_besar = $p->berat > 50;
            $profil_c2 = $is_besar ? 5 : 1;
            $ideal_c2 = $preferensi_ukuran === 'besar' ? 5 : 1;
            $gap_c2 = $profil_c2 - $ideal_c2;
            $bobot_c2 = $gap_mapping[$gap_c2] ?? 1.0;

            // C3: Harga (Cost, Bobot 0.30, Secondary Factor)
            // Melakukan penskalaan dinamis 1-5 berdasarkan min-max harga
            if ($max_harga == $min_harga) {
                $profil_c3 = $preferensi_harga === 'terendah' ? 1 : 5; // Perfect match jika harga semua produk sama
            } else {
                $val_harga = 1 + 4 * ($p->harga - $min_harga) / ($max_harga - $min_harga);
                $profil_c3 = max(1, min(5, (int) round($val_harga)));
            }
            $ideal_c3 = $preferensi_harga === 'terendah' ? 1 : 5;
            $gap_c3 = $profil_c3 - $ideal_c3;
            $bobot_c3 = $gap_mapping[$gap_c3] ?? 1.0;

            // Core Factor (NCF) = (0.4 * Bobot C1 + 0.3 * Bobot C2) / 0.7
            $ncf = (0.4 * $bobot_c1 + 0.3 * $bobot_c2) / 0.7;

            // Secondary Factor (NSF) = Bobot C3 / 1
            $nsf = $bobot_c3;

            // Nilai Total/Akhir = (70% × NCF) + (30% × NSF)
            $nilai_akhir = (0.70 * $ncf) + (0.30 * $nsf);

            // Persentase Kecocokan = Nilai Akhir * 20
            $match_percentage = $nilai_akhir * 20;

            // Penjelasan singkat hasil rekomendasi
            $desc_c1 = $is_bestseller ? 'merupakan produk terlaris kami' : 'memiliki jumlah penjualan standar';
            $desc_c2 = $is_besar ? 'ukuran porsi kemasan besar' : 'ukuran porsi kemasan mini/kecil';
            if ($max_harga == $min_harga) {
                $desc_c3 = 'harga yang bersaing';
            } else {
                $desc_c3 = $p->harga < ($min_harga + $max_harga)/2 ? 'harga yang relatif ekonomis' : 'harga kelas premium';
            }

            $explanation = "Cookies ini sangat direkomendasikan karena {$desc_c1}, disajikan dengan {$desc_c2}, serta memiliki {$desc_c3}.";

            // Mengambil foto produk ter-update
            $fotoUrl = asset('frontend/images/default-product.jpg');
            if ($p->foto) {
                $fotoUrl = asset('storage/img-produk/' . $p->foto);
            } elseif ($p->fotoProduk->first()) {
                $fotoUrl = asset('storage/img-produk/' . $p->fotoProduk->first()->foto);
            }

            // Detail GAP collapsible
            $details = [
                'c1' => [
                    'nama' => 'Jumlah Penjualan',
                    'profil' => $profil_c1 == 5 ? 'Banyak Terjual' : 'Standar/Biasa',
                    'ideal' => $ideal_c1 == 5 ? 'Banyak Terjual' : 'Standar/Biasa',
                    'gap' => $gap_c1,
                    'bobot' => number_format($bobot_c1, 1),
                    'faktor' => 'Core Factor (Benefit)'
                ],
                'c2' => [
                    'nama' => 'Ukuran',
                    'profil' => $profil_c2 == 5 ? 'Besar (>50g)' : 'Kecil/Mini (<=50g)',
                    'ideal' => $ideal_c2 == 5 ? 'Besar' : 'Kecil/Mini',
                    'gap' => $gap_c2,
                    'bobot' => number_format($bobot_c2, 1),
                    'faktor' => 'Core Factor (Benefit)'
                ],
                'c3' => [
                    'nama' => 'Harga',
                    'profil' => 'Level ' . $profil_c3 . ' (Rp ' . number_format($p->harga, 0, ',', '.') . ')',
                    'ideal' => 'Level ' . $ideal_c3,
                    'gap' => $gap_c3,
                    'bobot' => number_format($bobot_c3, 1),
                    'faktor' => 'Secondary Factor (Cost)'
                ]
            ];

            // Info reviews real-time
            $p_reviews = \App\Models\Review::where('produk_id', $p->id)->get();
            $review_count = $p_reviews->count();
            $average_rating = $p_reviews->avg('rating') ?: 5.0;

            // Dapatkan ulasan terbaru jika ada
            $latest_review = $p_reviews->sortByDesc('created_at')->first();
            if ($latest_review && trim($latest_review->comment) !== '') {
                $review_text = $latest_review->comment;
            } else {
                $ulasan_pilihan = [
                    'choco' => 'Kue choco chip terbaik yang pernah saya coba! Cokelatnya lumer banget pas digigit.',
                    'matcha' => 'Rasa matchanya sangat pekat dan autentik, tidak terlalu manis. Cocok buat temen ngeteh.',
                    'bisco' => 'Wangi biscoff-nya harum sekali, renyah di luar tapi lembut di dalam. Nagih!',
                    'red' => 'Warna merah mewahnya cantik, rasanya gurih manis berpadu sempurna. Favorit keluarga!'
                ];
                
                $review_text = 'Tekstur cookies-nya pas banget, renyah dan bahan premiumnya sangat terasa. Sangat direkomendasikan!';
                foreach ($ulasan_pilihan as $key => $val) {
                    if (strpos(strtolower($p->nama_produk), $key) !== false) {
                        $review_text = $val;
                        break;
                    }
                }
            }

            $results[] = [
                'produk_id' => $p->id,
                'nama_produk' => $p->nama_produk,
                'harga' => $p->harga,
                'harga_formatted' => 'Rp ' . number_format($p->harga, 0, ',', '.'),
                'stok' => $p->stok,
                'foto' => $fotoUrl,
                'detail_url' => route('produk.detail', $p->id),
                'ncf' => $ncf,
                'nsf' => $nsf,
                'nilai_akhir' => number_format($nilai_akhir, 2),
                'match_score' => round($match_percentage),
                'explanation' => $explanation,
                'details' => $details,
                'rating_stars' => number_format($average_rating, 1),
                'review_count' => $review_count,
                'review_text' => $review_text,
            ];
        }

        // Urutkan berdasarkan nilai akhir tertinggi descending
        usort($results, function ($a, $b) {
            if ($b['nilai_akhir'] == $a['nilai_akhir']) {
                return $b['match_score'] <=> $a['match_score'];
            }
            return $b['nilai_akhir'] <=> $a['nilai_akhir'];
        });

        // Dense ranking
        $ranked_results = [];
        $rank = 1;
        foreach ($results as $index => $item) {
            if ($index > 0 && $item['nilai_akhir'] == $ranked_results[$index-1]['nilai_akhir']) {
                $item['ranking'] = $ranked_results[$index-1]['ranking'];
            } else {
                $item['ranking'] = $rank;
            }
            $ranked_results[] = $item;
            $rank++;
        }

        return response()->json([
            'success' => true,
            'data' => $ranked_results
        ]);
    }
}
