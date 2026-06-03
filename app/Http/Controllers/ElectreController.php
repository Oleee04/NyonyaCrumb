<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Exception;

class ElectreController extends Controller
{
    public function index()
    {
        return view('backend.v_electre.index');
    }

    public function hasil()
    {
        $result = session('electre_result');

        if (!$result) {
            return redirect()
                ->route('backend.electre.index')
                ->with('error', 'Silakan upload file Excel terlebih dahulu.');
        }

        return view('backend.v_electre.hasil', compact('result'));
    }
    public function hitung(Request $request)
    {
        $request->validate([
            'file_excel' => 'required|mimes:xlsx,xls,csv',
        ]);

        try {
            $filePath = $request->file('file_excel')->getRealPath();

            $spreadsheet = IOFactory::load($filePath);
            $sheet = $spreadsheet->getActiveSheet();

            $rows = $sheet->toArray(null, true, true, true);

            $data = $this->readInputRows($rows);

            if (count($data) < 2) {
                return back()->with('error', 'Data minimal harus memiliki 2 alternatif.');
            }

            $criteria = ['C1', 'C2', 'C3'];

            /*
             * Bobot kriteria.
             * Sesuaikan dengan bobot yang kamu pakai di Excel.
             */
            $weights = [
                'C1' => 0.4,
                'C2' => 0.3,
                'C3' => 0.3,
            ];

            $result = $this->calculateElectre($data, $criteria, $weights);

            /*
             * Setelah upload dan hitung,
             * hasil akan ditampilkan di halaman hasil.blade.php
             */
            session(['electre_result' => $result]);

            return redirect()->route('backend.electre.hasil');

        } catch (Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    private function readInputRows(array $rows): array
    {
        $headerRowIndex = null;
        $columns = [];

        foreach ($rows as $rowIndex => $row) {
            $tempColumns = [];

            foreach ($row as $col => $value) {
                $label = $this->cleanHeader($value);

                if ($label !== '' && !isset($tempColumns[$label])) {
                    $tempColumns[$label] = $col;
                }
            }

            if (
                isset($tempColumns['nama produk']) &&
                isset($tempColumns['alternatif']) &&
                isset($tempColumns['c1']) &&
                isset($tempColumns['c2']) &&
                isset($tempColumns['c3'])
            ) {
                $headerRowIndex = $rowIndex;
                $columns = $tempColumns;
                break;
            }
        }

        if ($headerRowIndex === null) {
            throw new Exception('Header Excel harus berisi: Nama Produk, Alternatif, C1, C2, C3');
        }

        $data = [];

        foreach ($rows as $rowIndex => $row) {
            if ($rowIndex <= $headerRowIndex) {
                continue;
            }

            $namaProduk = trim((string) ($row[$columns['nama produk']] ?? ''));
            $alternatif = trim((string) ($row[$columns['alternatif']] ?? ''));

            if ($namaProduk === '' || $alternatif === '') {
                continue;
            }

            $data[] = [
                'nama_produk' => $namaProduk,
                'alternatif' => $alternatif,
                'nilai' => [
                    'C1' => $this->toNumber($row[$columns['c1']] ?? 0),
                    'C2' => $this->toNumber($row[$columns['c2']] ?? 0),
                    'C3' => $this->toNumber($row[$columns['c3']] ?? 0),
                ],
            ];
        }

        return $data;
    }

    private function calculateElectre(array $data, array $criteria, array $weights): array
    {
        $alternatives = array_column($data, 'alternatif');

        $productNames = [];
        $nilai = [];

        foreach ($data as $row) {
            $alt = $row['alternatif'];

            $productNames[$alt] = $row['nama_produk'];
            $nilai[$alt] = $row['nilai'];
        }

        /*
         * STEP 1
         * Normalisasi Matriks Keputusan
         *
         * Rumus:
         * R_ij = X_ij / sqrt(sum X_ij^2)
         */
        $dividers = [];

        foreach ($criteria as $criterion) {
            $sumSquare = 0;

            foreach ($alternatives as $alt) {
                $sumSquare += pow($nilai[$alt][$criterion], 2);
            }

            $dividers[$criterion] = sqrt($sumSquare);
        }

        $normalisasi = [];

        foreach ($alternatives as $alt) {
            foreach ($criteria as $criterion) {
                if ($dividers[$criterion] == 0) {
                    $normalisasi[$alt][$criterion] = 0;
                } else {
                    $normalisasi[$alt][$criterion] = $nilai[$alt][$criterion] / $dividers[$criterion];
                }
            }
        }

        /*
         * STEP 2
         * Matriks Preferensi
         *
         * Rumus:
         * V_ij = R_ij * W_j
         */
        $preferensi = [];

        foreach ($alternatives as $alt) {
            foreach ($criteria as $criterion) {
                $preferensi[$alt][$criterion] = $normalisasi[$alt][$criterion] * $weights[$criterion];
            }
        }

        /*
         * STEP 3
         * Matriks Concordance
         *
         * Jika X_a >= X_b, maka bobot kriterianya dijumlahkan.
         * Gunakan toleransi yang cukup (epsilon) untuk menangani perbedaan pembulatan Excel vs PHP.
         */
        $concordance = [];
        $epsilon = 0.0001; // Toleransi lebih luas untuk menyamakan dengan Excel

        foreach ($alternatives as $a) {
            foreach ($alternatives as $b) {
                if ($a === $b) {
                    $concordance[$a][$b] = 0;
                    continue;
                }

                $sum = 0;

                foreach ($criteria as $criterion) {
                    $valA = (float)$nilai[$a][$criterion];
                    $valB = (float)$nilai[$b][$criterion];

                    // Perbandingan >= dengan toleransi epsilon
                    if ($valA >= $valB || abs($valA - $valB) < $epsilon) {
                        $sum += (float)$weights[$criterion];
                    }
                }

                $concordance[$a][$b] = round($sum, 4);
            }
        }

        /*
         * STEP 4
         * Matriks Discordance
         *
         * Rumus yang digunakan:
         * D_ab = max selisih pasangan alternatif / max selisih global
         */
        $globalMaxDiff = 0;

        foreach ($alternatives as $a) {
            foreach ($alternatives as $b) {
                if ($a === $b) {
                    continue;
                }

                foreach ($criteria as $criterion) {
                    $diff = abs($preferensi[$a][$criterion] - $preferensi[$b][$criterion]);
                    $globalMaxDiff = max($globalMaxDiff, $diff);
                }
            }
        }

        $discordance = [];

        foreach ($alternatives as $a) {
            foreach ($alternatives as $b) {
                if ($a === $b) {
                    $discordance[$a][$b] = 0;
                    continue;
                }

                $maxDiffPair = 0;

                foreach ($criteria as $criterion) {
                    $diff = abs($preferensi[$a][$criterion] - $preferensi[$b][$criterion]);
                    $maxDiffPair = max($maxDiffPair, $diff);
                }

                if ($globalMaxDiff == 0) {
                    $discordance[$a][$b] = 0;
                } else {
                    $discordance[$a][$b] = $maxDiffPair / $globalMaxDiff;
                }
            }
        }

        /*
         * STEP 5
         * Threshold Concordance dan Discordance
         */
        $thresholdConcordance = $this->averageOffDiagonal($concordance, $alternatives);
        $thresholdDiscordance = $this->averageOffDiagonal($discordance, $alternatives);

        /*
         * STEP 6
         * Matriks Dominan Concordance
         */
        $dominantConcordance = [];

        foreach ($alternatives as $a) {
            foreach ($alternatives as $b) {
                if ($a === $b) {
                    $dominantConcordance[$a][$b] = 0;
                    continue;
                }

                $dominantConcordance[$a][$b] = $concordance[$a][$b] >= $thresholdConcordance ? 1 : 0;
            }
        }

        /*
         * STEP 7
         * Matriks Dominan Discordance
         *
         * Dibuat mengikuti pola Excel sebelumnya:
         * Jika discordance >= threshold discordance, maka 1.
         */
        $dominantDiscordance = [];

        foreach ($alternatives as $a) {
            foreach ($alternatives as $b) {
                if ($a === $b) {
                    $dominantDiscordance[$a][$b] = 0;
                    continue;
                }

                $dominantDiscordance[$a][$b] = $discordance[$a][$b] >= $thresholdDiscordance ? 1 : 0;
            }
        }

        /*
         * STEP 8
         * Aggregate Dominance
         *
         * Rumus:
         * E_ab = F_ab * G_ab
         */
        $aggregate = [];

        foreach ($alternatives as $a) {
            foreach ($alternatives as $b) {
                $aggregate[$a][$b] = $dominantConcordance[$a][$b] * $dominantDiscordance[$a][$b];
            }
        }

        /*
         * STEP 9
         * Ranking
         *
         * Default mengikuti contoh Excel:
         * ranking diambil dari jumlah dominasi concordance.
         *
         * Kalau ingin pakai aggregate dominance,
         * ubah menjadi:
         * $rankingSource = 'aggregate';
         */
        $rankingSource = 'aggregate';

        if ($rankingSource === 'aggregate') {
            $sourceMatrix = $aggregate;
        } else {
            $sourceMatrix = $dominantConcordance;
        }

        $scores = [];

        foreach ($alternatives as $alt) {
            $scores[$alt] = array_sum($sourceMatrix[$alt]);
        }

        arsort($scores);

        /*
         * Dense rank: alternatif dengan jumlah dominasi sama
         * mendapatkan nomor ranking yang sama, persis seperti
         * fungsi RANK() di Excel.
         */
        $ranking = [];
        $uniqueScores = array_values(array_unique(array_values($scores)));
        rsort($uniqueScores);
        $scoreToRank = [];
        foreach ($uniqueScores as $i => $val) {
            $scoreToRank[$val] = $i + 1;
        }

        foreach ($scores as $alt => $score) {
            $ranking[] = [
                'ranking'         => $scoreToRank[$score],
                'alternatif'      => $alt,
                'nama_produk'     => $productNames[$alt],
                'jumlah_dominasi' => $score,
            ];
        }

        return [
            'data' => $data,
            'criteria' => $criteria,
            'weights' => $weights,
            'alternatives' => $alternatives,
            'nilai' => $nilai,
            'normalisasi' => $normalisasi,
            'preferensi' => $preferensi,
            'concordance' => $concordance,
            'discordance' => $discordance,
            'threshold_concordance' => $thresholdConcordance,
            'threshold_discordance' => $thresholdDiscordance,
            'dominant_concordance' => $dominantConcordance,
            'dominant_discordance' => $dominantDiscordance,
            'aggregate' => $aggregate,
            'ranking' => $ranking,
        ];
    }

    private function averageOffDiagonal(array $matrix, array $alternatives): float
    {
        $sum = 0;
        $count = 0;

        foreach ($alternatives as $a) {
            foreach ($alternatives as $b) {
                if ($a === $b) {
                    continue;
                }

                $sum += $matrix[$a][$b];
                $count++;
            }
        }

        if ($count == 0) {
            return 0;
        }

        return $sum / $count;
    }

    private function cleanHeader(mixed $value): string
    {
        $value = strtolower(trim((string) $value));
        $value = preg_replace('/\s+/', ' ', $value);

        return $value;
    }

    private function toNumber(mixed $value): float
    {
        if ($value === null || $value === '') {
            return 0;
        }

        if (is_numeric($value)) {
            return (float) $value;
        }

        $strValue = (string)$value;
        $isPercentage = str_contains($strValue, '%');

        // Membersihkan karakter non-numerik kecuali titik dan koma
        $cleaned = preg_replace('/[^0-9,.]/', '', $strValue);
        $cleaned = str_replace(',', '.', $cleaned);

        if (is_numeric($cleaned)) {
            $num = (float)$cleaned;
            return $isPercentage ? $num / 100 : $num;
        }

        return 0;
    }
}