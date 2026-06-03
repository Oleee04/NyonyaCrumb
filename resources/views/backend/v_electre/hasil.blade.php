@extends('backend.v_layouts.app')

@section('content')
<style>
    :root {
        --cocoa: #7a6254;
        --cocoa-deep: #5d493e;
        --cocoa-light: rgba(122,98,84,0.08);
        --sand: #fdfaf7;
        --border: #ede8e3;
        --text: #2c231e;
        --text-muted: #8b7b6e;
        --white: #ffffff;
        --gold: #c8a96e;
        --green-bg: #ecfdf5;
        --green-text: #065f46;
        --green-border: #a7f3d0;
    }

    .ep { padding: 32px 24px; min-height: calc(100vh - 80px); background: var(--sand); font-family: 'DM Sans', sans-serif; }

    /* ── Header ── */
    .ep-header { display: flex; justify-content: space-between; align-items: flex-start; gap: 16px; margin-bottom: 28px; flex-wrap: wrap; }
    .ep-header h1 { margin: 0; font-size: 26px; font-weight: 700; color: var(--text); letter-spacing: -0.3px; }
    .ep-header p  { margin: 4px 0 0; color: var(--text-muted); font-size: 14px; }
    .btn-back { display: inline-flex; align-items: center; gap: 8px; text-decoration: none;
        background: var(--cocoa); color: #fff; padding: 10px 18px; border-radius: 10px;
        font-size: 13px; font-weight: 600; transition: background 0.2s; }
    .btn-back:hover { background: var(--cocoa-deep); color: #fff; }

    /* ── Success banner ── */
    .success-banner { display: flex; align-items: center; gap: 12px; background: var(--green-bg);
        border: 1px solid var(--green-border); border-radius: 12px; padding: 14px 18px;
        color: var(--green-text); font-size: 14px; margin-bottom: 24px; }

    /* ── Card ── */
    .step-card { background: var(--white); border: 1px solid var(--border); border-radius: 20px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.04); overflow: hidden; }

    /* ── Progress bar ── */
    .progress-bar { height: 3px; background: var(--border); }
    .progress-fill { height: 100%; background: linear-gradient(90deg, var(--gold), var(--cocoa));
        border-radius: 2px; transition: width 0.4s ease; }

    /* ── Step header ── */
    .step-header { padding: 24px 28px 0; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 12px; }
    .step-meta { display: flex; align-items: center; gap: 12px; }
    .step-badge { background: var(--cocoa-light); color: var(--cocoa); font-size: 11px;
        font-weight: 700; letter-spacing: 1px; text-transform: uppercase;
        padding: 4px 10px; border-radius: 20px; }
    .step-title { font-size: 20px; font-weight: 700; color: var(--text); margin: 0; }
    .step-desc  { font-size: 13px; color: var(--text-muted); margin: 4px 0 0; }

    /* ── Steps dots ── */
    .steps-dots { display: flex; gap: 6px; }
    .dot { width: 8px; height: 8px; border-radius: 50%; background: var(--border); transition: background 0.3s; cursor: pointer; }
    .dot.active { background: var(--cocoa); transform: scale(1.2); }
    .dot.done   { background: var(--gold); }

    /* ── Panel body ── */
    .step-body { padding: 20px 28px 24px; }
    .step-panel { display: none; animation: fadeUp 0.35s ease forwards; }
    .step-panel.active { display: block; }
    @keyframes fadeUp { from { opacity:0; transform:translateY(8px); } to { opacity:1; transform:translateY(0); } }

    /* ── Threshold badge ── */
    .threshold-tag { display: inline-flex; align-items: center; gap: 8px;
        background: var(--cocoa-light); border: 1px solid var(--border);
        color: var(--cocoa-deep); padding: 8px 14px; border-radius: 10px;
        font-size: 13px; font-weight: 600; margin-bottom: 16px; }

    /* ── Table ── */
    .tbl-wrap { width: 100%; overflow-x: auto; border: 1px solid var(--border); border-radius: 14px; }
    table { width: 100%; min-width: 600px; border-collapse: collapse; }
    th, td { padding: 12px 15px; text-align: center; font-size: 13px; color: var(--text); border-bottom: 1px solid #f1ede9; white-space: nowrap; }
    th { background: #faf7f4; color: var(--text-muted); font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; }
    tr:last-child td { border-bottom: none; }
    tr:hover td { background: #fdf8f5; }
    td.left, th.left { text-align: left; }
    .rank-1 td { background: var(--green-bg) !important; color: var(--green-text) !important; font-weight: 700; }
    .rank-badge { display: inline-flex; align-items: center; justify-content: center;
        width: 28px; height: 28px; border-radius: 50%; font-size: 13px; font-weight: 700; }
    .rank-badge.gold { background: #fef3c7; color: #92400e; }
    .rank-badge.silver { background: #f1f5f9; color: #475569; }
    .rank-badge.bronze { background: #fff7ed; color: #9a3412; }

    /* ── Navigation ── */
    .step-nav { display: flex; align-items: center; justify-content: space-between;
        padding: 16px 28px 24px; border-top: 1px solid var(--border); margin-top: 4px; }
    .step-counter { font-size: 13px; color: var(--text-muted); font-weight: 500; }
    .nav-btns { display: flex; gap: 10px; }
    .nav-btn { display: inline-flex; align-items: center; gap: 7px; padding: 9px 18px;
        border: none; border-radius: 10px; font-size: 13px; font-weight: 600;
        cursor: pointer; transition: all 0.2s ease; }
    .nav-btn.prev { background: var(--cocoa-light); color: var(--cocoa-deep); }
    .nav-btn.prev:hover { background: #e8ddd6; }
    .nav-btn.next { background: var(--cocoa); color: #fff; }
    .nav-btn.next:hover { background: var(--cocoa-deep); transform: translateX(2px); }
    .nav-btn:disabled { opacity: 0.35; cursor: not-allowed; transform: none !important; }

    /* ── Chart section ── */
    .chart-section { margin-top: 24px; }
    .chart-section-title { font-size: 15px; font-weight: 700; color: var(--text); margin: 0 0 16px;
        display: flex; align-items: center; gap: 8px; }
    .chart-section-title i { color: var(--gold); }
    .charts-grid { display: grid; grid-template-columns: 1fr 340px; gap: 20px; }
    @media (max-width: 900px) { .charts-grid { grid-template-columns: 1fr; } }
    .chart-card { background: var(--white); border: 1px solid var(--border); border-radius: 16px;
        padding: 20px 22px; box-shadow: 0 4px 16px rgba(0,0,0,0.03); }
    .chart-card h3 { font-size: 13px; font-weight: 700; color: var(--text-muted); text-transform: uppercase;
        letter-spacing: 0.8px; margin: 0 0 16px; }
    .chart-canvas-wrap { position: relative; }
</style>

@php
    $fmt = function (mixed $v): string {
        if (!is_numeric($v)) return (string) $v;
        return rtrim(rtrim(number_format((float)$v, 5, '.', ''), '0'), '.');
    };
    $steps = [
        ['id'=>'data',        'label'=>'Data Alternatif',     'short'=>'Data'],
        ['id'=>'bobot',       'label'=>'Kriteria & Bobot',    'short'=>'Bobot'],
        ['id'=>'normalisasi', 'label'=>'Normalisasi R',       'short'=>'Norm.'],
        ['id'=>'preferensi',  'label'=>'Preferensi V',        'short'=>'Pref.'],
        ['id'=>'concordance', 'label'=>'Concordance',         'short'=>'Conc.'],
        ['id'=>'discordance', 'label'=>'Discordance',         'short'=>'Disc.'],
        ['id'=>'dominan-c',   'label'=>'Dominan C',           'short'=>'Dom.C'],
        ['id'=>'dominan-d',   'label'=>'Dominan D',           'short'=>'Dom.D'],
        ['id'=>'aggregate',   'label'=>'Aggregate',           'short'=>'Agg.'],
        ['id'=>'ranking',     'label'=>'Ranking Akhir',       'short'=>'Rank'],
        ['id'=>'grafik',      'label'=>'Visualisasi Grafik',   'short'=>'Graf'],
    ];
    $total = count($steps);
@endphp

<div class="ep">

    <div class="ep-header">
        <div>
            <h1>Hasil Perhitungan ELECTRE</h1>
            <p>{{ $total }} tahap perhitungan tersedia — gunakan navigasi untuk berpindah antar langkah.</p>
        </div>
        <a href="{{ route('backend.electre.index') }}" class="btn-back">
            <i class="fas fa-arrow-left"></i> Upload Ulang
        </a>
    </div>

    <div class="success-banner">
        <i class="fas fa-check-circle"></i>
        <span>Data berhasil dihitung menggunakan metode <strong>ELECTRE</strong>. Terdapat <strong>{{ count($result['alternatives']) }}</strong> alternatif dan <strong>{{ count($result['criteria']) }}</strong> kriteria.</span>
    </div>

    <div class="step-card">

        <!-- Progress bar -->
        <div class="progress-bar">
            <div class="progress-fill" id="progressFill" style="width:10%"></div>
        </div>

        <!-- Step header -->
        <div class="step-header">
            <div>
                <div class="step-meta">
                    <span class="step-badge" id="stepBadge">Langkah 1 / {{ $total }}</span>
                </div>
                <h2 class="step-title" id="stepTitle">Data Alternatif</h2>
                <p class="step-desc" id="stepDesc">Data awal dari Excel yang sudah dilikertkan.</p>
            </div>
            <div class="steps-dots" id="stepsDots">
                @foreach($steps as $i => $s)
                    <div class="dot {{ $i === 0 ? 'active' : '' }}" data-step="{{ $i }}" title="{{ $s['label'] }}"></div>
                @endforeach
            </div>
        </div>

        <!-- Panels -->
        <div class="step-body">

            {{-- STEP 1: Data --}}
            <div class="step-panel active" data-panel="0">
                <div class="tbl-wrap">
                    <table>
                        <thead><tr>
                            <th class="left">Nama Produk</th>
                            <th>Alternatif</th>
                            @foreach($result['criteria'] as $c)<th>{{ $c }}</th>@endforeach
                        </tr></thead>
                        <tbody>
                            @foreach($result['data'] as $row)
                            <tr>
                                <td class="left">{{ $row['nama_produk'] }}</td>
                                <td>{{ $row['alternatif'] }}</td>
                                @foreach($result['criteria'] as $c)<td>{{ $fmt($row['nilai'][$c]) }}</td>@endforeach
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- STEP 2: Bobot --}}
            <div class="step-panel" data-panel="1">
                <div class="tbl-wrap">
                    <table>
                        <thead><tr>
                            @foreach($result['criteria'] as $c)<th>{{ $c }}</th>@endforeach
                        </tr></thead>
                        <tbody><tr>
                            @foreach($result['criteria'] as $c)<td>{{ $fmt($result['weights'][$c]) }}</td>@endforeach
                        </tr></tbody>
                    </table>
                </div>
            </div>

            {{-- STEP 3: Normalisasi --}}
            <div class="step-panel" data-panel="2">
                <div class="tbl-wrap">
                    <table>
                        <thead><tr>
                            <th>Alternatif</th>
                            @foreach($result['criteria'] as $c)<th>{{ $c }}</th>@endforeach
                        </tr></thead>
                        <tbody>
                            @foreach($result['alternatives'] as $alt)
                            <tr>
                                <td>{{ $alt }}</td>
                                @foreach($result['criteria'] as $c)<td>{{ $fmt($result['normalisasi'][$alt][$c]) }}</td>@endforeach
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- STEP 4: Preferensi --}}
            <div class="step-panel" data-panel="3">
                <div class="tbl-wrap">
                    <table>
                        <thead><tr>
                            <th>Alternatif</th>
                            @foreach($result['criteria'] as $c)<th>{{ $c }}</th>@endforeach
                        </tr></thead>
                        <tbody>
                            @foreach($result['alternatives'] as $alt)
                            <tr>
                                <td>{{ $alt }}</td>
                                @foreach($result['criteria'] as $c)<td>{{ $fmt($result['preferensi'][$alt][$c]) }}</td>@endforeach
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- STEP 5: Concordance --}}
            <div class="step-panel" data-panel="4">
                <div class="threshold-tag">
                    <i class="fas fa-sliders-h"></i>
                    Threshold Concordance: <strong>{{ $fmt($result['threshold_concordance']) }}</strong>
                </div>
                <div class="tbl-wrap">
                    <table>
                        <thead><tr>
                            <th>Alt</th>
                            @foreach($result['alternatives'] as $a)<th>{{ $a }}</th>@endforeach
                        </tr></thead>
                        <tbody>
                            @foreach($result['alternatives'] as $r)
                            <tr>
                                <td>{{ $r }}</td>
                                @foreach($result['alternatives'] as $col)<td>{{ $fmt($result['concordance'][$r][$col]) }}</td>@endforeach
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- STEP 6: Discordance --}}
            <div class="step-panel" data-panel="5">
                <div class="threshold-tag">
                    <i class="fas fa-sliders-h"></i>
                    Threshold Discordance: <strong>{{ $fmt($result['threshold_discordance']) }}</strong>
                </div>
                <div class="tbl-wrap">
                    <table>
                        <thead><tr>
                            <th>Alt</th>
                            @foreach($result['alternatives'] as $a)<th>{{ $a }}</th>@endforeach
                        </tr></thead>
                        <tbody>
                            @foreach($result['alternatives'] as $r)
                            <tr>
                                <td>{{ $r }}</td>
                                @foreach($result['alternatives'] as $col)<td>{{ $fmt($result['discordance'][$r][$col]) }}</td>@endforeach
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- STEP 7: Dominan C --}}
            <div class="step-panel" data-panel="6">
                <div class="tbl-wrap">
                    <table>
                        <thead><tr>
                            <th>Alt</th>
                            @foreach($result['alternatives'] as $a)<th>{{ $a }}</th>@endforeach
                        </tr></thead>
                        <tbody>
                            @foreach($result['alternatives'] as $r)
                            <tr>
                                <td>{{ $r }}</td>
                                @foreach($result['alternatives'] as $col)<td>{{ $result['dominant_concordance'][$r][$col] }}</td>@endforeach
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- STEP 8: Dominan D --}}
            <div class="step-panel" data-panel="7">
                <div class="tbl-wrap">
                    <table>
                        <thead><tr>
                            <th>Alt</th>
                            @foreach($result['alternatives'] as $a)<th>{{ $a }}</th>@endforeach
                        </tr></thead>
                        <tbody>
                            @foreach($result['alternatives'] as $r)
                            <tr>
                                <td>{{ $r }}</td>
                                @foreach($result['alternatives'] as $col)<td>{{ $result['dominant_discordance'][$r][$col] }}</td>@endforeach
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- STEP 9: Aggregate --}}
            <div class="step-panel" data-panel="8">
                <div class="tbl-wrap">
                    <table>
                        <thead><tr>
                            <th>Alt</th>
                            @foreach($result['alternatives'] as $a)<th>{{ $a }}</th>@endforeach
                        </tr></thead>
                        <tbody>
                            @foreach($result['alternatives'] as $r)
                            <tr>
                                <td>{{ $r }}</td>
                                @foreach($result['alternatives'] as $col)<td>{{ $result['aggregate'][$r][$col] }}</td>@endforeach
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- STEP 10: Ranking --}}
            <div class="step-panel" data-panel="9">
                <div class="tbl-wrap">
                    <table>
                        <thead><tr>
                            <th>Rank</th>
                            <th>Alternatif</th>
                            <th class="left">Nama Produk</th>
                            <th>Jumlah Dominasi</th>
                        </tr></thead>
                        <tbody>
                            @foreach($result['ranking'] as $row)
                            <tr class="{{ $row['ranking'] == 1 ? 'rank-1' : '' }}">
                                <td>
                                    @php $rn = $row['ranking']; @endphp
                                    <span class="rank-badge {{ $rn==1?'gold':($rn==2?'silver':($rn==3?'bronze':'')) }}">
                                        {{ $rn == 1 ? '🥇' : ($rn == 2 ? '🥈' : ($rn == 3 ? '🥉' : $rn)) }}
                                    </span>
                                </td>
                                <td><strong>{{ $row['alternatif'] }}</strong></td>
                                <td class="left">{{ $row['nama_produk'] }}</td>
                                <td><strong>{{ $row['jumlah_dominasi'] }}</strong></td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- STEP 11: Grafik --}}
            <div class="step-panel" data-panel="10">
                <div class="charts-grid">
                    <div class="chart-card">
                        <h3>Jumlah Dominasi per Alternatif</h3>
                        <div class="chart-canvas-wrap">
                            <canvas id="barChart"></canvas>
                        </div>
                    </div>
                    <div class="chart-card">
                        <h3>Proporsi Dominasi</h3>
                        <div class="chart-canvas-wrap">
                            <canvas id="doughnutChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>

        </div><!-- /step-body -->

        <!-- Navigation -->
        <div class="step-nav">
            <span class="step-counter" id="stepCounter">Langkah 1 dari {{ $total }}</span>
            <div class="nav-btns">
                <button class="nav-btn prev" id="btnPrev" onclick="goStep(currentStep - 1)" disabled>
                    <i class="fas fa-chevron-left"></i> Sebelumnya
                </button>
                <button class="nav-btn next" id="btnNext" onclick="goStep(currentStep + 1)">
                    Selanjutnya <i class="fas fa-chevron-right"></i>
                </button>
            </div>
        </div>

    </div><!-- /step-card -->


</div><!-- /ep -->

@php
$stepsJs = array_values(array_map(function($s) {
    $descs = [
        'data'        => 'Data awal dari Excel yang sudah dilikertkan.',
        'bobot'       => 'Bobot kriteria yang digunakan pada proses perhitungan.',
        'normalisasi' => 'Hasil normalisasi matriks keputusan.',
        'preferensi'  => 'Normalisasi R dikalikan dengan bobot kriteria.',
        'concordance' => 'Matriks perbandingan concordance antar alternatif.',
        'discordance' => 'Matriks perbandingan discordance antar alternatif.',
        'dominan-c'   => 'Matriks dominan concordance berdasarkan threshold.',
        'dominan-d'   => 'Matriks dominan discordance berdasarkan threshold.',
        'aggregate'   => 'Perkalian matriks dominan concordance dan discordance.',
        'ranking'     => 'Hasil akhir perangkingan seluruh alternatif.',
        'grafik'      => 'Visualisasi bar chart dan doughnut chart hasil ELECTRE.',
    ];
    return ['label' => $s['label'], 'desc' => $descs[$s['id']] ?? ''];
}, $steps));
@endphp

<script>
const STEPS = @json($stepsJs);

const TOTAL = {{ $total }};
let currentStep = 0;

function goStep(n) {
    if (n < 0 || n >= TOTAL) return;

    // update panels
    document.querySelectorAll('.step-panel').forEach((p, i) => {
        p.classList.toggle('active', i === n);
    });

    // dots
    document.querySelectorAll('.dot').forEach((d, i) => {
        d.classList.toggle('active', i === n);
        d.classList.toggle('done', i < n);
    });

    // header text
    document.getElementById('stepBadge').textContent  = `Langkah ${n+1} / ${TOTAL}`;
    document.getElementById('stepTitle').textContent  = STEPS[n].label;
    document.getElementById('stepDesc').textContent   = STEPS[n].desc;
    document.getElementById('stepCounter').textContent = `Langkah ${n+1} dari ${TOTAL}`;

    // progress
    document.getElementById('progressFill').style.width = `${((n+1)/TOTAL)*100}%`;

    // buttons
    document.getElementById('btnPrev').disabled = n === 0;
    const nextBtn = document.getElementById('btnNext');
    if (n === TOTAL - 1) {
        nextBtn.disabled = true;
        nextBtn.innerHTML = '<i class="fas fa-check"></i> Selesai';
    } else {
        nextBtn.disabled = false;
        nextBtn.innerHTML = 'Selanjutnya <i class="fas fa-chevron-right"></i>';
    }

    currentStep = n;
}

// dot click
document.querySelectorAll('.dot').forEach((d, i) => {
    d.addEventListener('click', () => goStep(i));
});

// init
goStep(0);
</script>

{{-- Chart.js --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.2/dist/chart.umd.min.js"></script>
@php
    $rankingData  = collect($result['ranking'])->sortBy('ranking')->values();
    $chartLabels  = $rankingData->pluck('alternatif')->toArray();
    $chartNames   = $rankingData->pluck('nama_produk')->toArray();
    $chartValues  = $rankingData->pluck('jumlah_dominasi')->toArray();
@endphp
<script>
(function() {
    const labels  = @json($chartLabels);
    const names   = @json($chartNames);
    const values  = @json($chartValues);

    const palette = [
        '#7a6254','#c8a96e','#a08070','#d4b896','#5d493e',
        '#b89a80','#e8d5be','#8b6e5a','#f0e6d8','#6b5248'
    ];

    /* ── Bar chart ── */
    const barCtx = document.getElementById('barChart');
    if (barCtx) {
        new Chart(barCtx, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Jumlah Dominasi',
                    data: values,
                    backgroundColor: labels.map((_, i) => palette[i % palette.length]),
                    borderRadius: 8,
                    borderSkipped: false,
                }]
            },
            options: {
                indexAxis: 'y',
                responsive: true,
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        callbacks: {
                            title: (ctx) => labels[ctx[0].dataIndex],
                            afterTitle: (ctx) => names[ctx[0].dataIndex],
                            label: (ctx) => ` Dominasi: ${ctx.raw}`,
                        }
                    }
                },
                scales: {
                    x: {
                        beginAtZero: true,
                        ticks: { stepSize: 1, font: { size: 12 }, color: '#8b7b6e' },
                        grid: { color: 'rgba(0,0,0,0.04)' }
                    },
                    y: {
                        ticks: { font: { size: 12, weight: '600' }, color: '#2c231e' },
                        grid: { display: false }
                    }
                }
            }
        });
    }

    /* ── Doughnut chart ── */
    const dCtx = document.getElementById('doughnutChart');
    if (dCtx) {
        const total = values.reduce((a, b) => a + b, 0);
        new Chart(dCtx, {
            type: 'doughnut',
            data: {
                labels: labels,
                datasets: [{
                    data: values,
                    backgroundColor: labels.map((_, i) => palette[i % palette.length]),
                    borderWidth: 2,
                    borderColor: '#fdfaf7',
                    hoverOffset: 8,
                }]
            },
            options: {
                responsive: true,
                cutout: '62%',
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: { font: { size: 12 }, color: '#2c231e', padding: 12, boxWidth: 12, borderRadius: 4 }
                    },
                    tooltip: {
                        callbacks: {
                            label: (ctx) => {
                                const pct = total > 0 ? ((ctx.raw / total) * 100).toFixed(1) : 0;
                                return ` ${ctx.raw} dominasi (${pct}%)`;
                            }
                        }
                    }
                }
            }
        });
    }
})();
</script>
@endsection