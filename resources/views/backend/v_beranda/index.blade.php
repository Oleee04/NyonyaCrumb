@extends('backend.v_layouts.app')

@section('content')
<style>
    .electre-step { margin-bottom: 30px; }
    .table-responsive { overflow-x: auto; }
    .table th { background-color: #f8f9fa; text-align: center; vertical-align: middle; }
    .table td { text-align: center; vertical-align: middle; }
    .table-ranking th { background-color: #28a745; color: white; }
</style>

<div class="row">
    <div class="col-12">
        
        <div class="card mb-4">
            <div class="card-body">
                <h4 class="card-title"><i class="fas fa-chart-line"></i> Sistem Pendukung Keputusan (SPK) - Metode ELECTRE</h4>
                <p>Dashboard ini menampilkan perhitungan metode ELECTRE untuk menentukan produk terlaris berdasarkan kriteria: Varian Rasa, Ukuran, Harga, dan Jumlah Terjual.</p>
                @if(isset($error))
                    <div class="alert alert-danger">{{ $error }}</div>
                @endif
            </div>
        </div>

        @if(isset($alternatives) && count($alternatives) > 0)
        <!-- 1. Kriteria & Bobot -->
        <div class="card electre-step">
            <div class="card-body">
                <h5 class="card-title">1. Kriteria dan Bobot (W)</h5>
                <table class="table table-bordered w-50">
                    <thead>
                        <tr>
                            <th>Kode Kriteria</th>
                            <th>Nama Kriteria</th>
                            <th>Bobot (W)</th>
                            <th>Atribut</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr><td>C1</td><td>Varian Rasa</td><td>{{ $weights[0] }}</td><td>Benefit</td></tr>
                        <tr><td>C2</td><td>Ukuran</td><td>{{ $weights[1] }}</td><td>Benefit</td></tr>
                        <tr><td>C3</td><td>Harga</td><td>{{ $weights[2] }}</td><td>Cost</td></tr>
                        <tr><td>C4</td><td>Jumlah Terjual</td><td>{{ $weights[3] }}</td><td>Benefit</td></tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- 2. Matriks Keputusan (X) -->
        <div class="card electre-step">
            <div class="card-body">
                <h5 class="card-title">2. Matriks Keputusan (X)</h5>
                <div class="table-responsive">
                    <table class="table table-bordered table-striped w-75">
                        <thead>
                            <tr>
                                <th>Alternatif</th>
                                <th>C1 (Rasa)</th>
                                <th>C2 (Ukuran)</th>
                                <th>C3 (Harga)</th>
                                <th>C4 (Terjual)</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($alternatives as $idx => $alt)
                            <tr>
                                <td class="text-left">{{ $alt['id'] }} - {{ $alt['nama'] }}</td>
                                <td>{{ $matrix_x[$idx][0] }}</td>
                                <td>{{ $matrix_x[$idx][1] }}</td>
                                <td>{{ $matrix_x[$idx][2] }}</td>
                                <td>{{ $matrix_x[$idx][3] }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- 3. Matriks Normalisasi (R) -->
        <div class="card electre-step">
            <div class="card-body">
                <h5 class="card-title">3. Matriks Normalisasi (R)</h5>
                <div class="table-responsive">
                    <table class="table table-bordered table-striped w-75">
                        <thead>
                            <tr>
                                <th>Alternatif</th>
                                <th>C1</th><th>C2</th><th>C3</th><th>C4</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($alternatives as $idx => $alt)
                            <tr>
                                <td>{{ $alt['id'] }}</td>
                                <td>{{ round($matrix_r[$idx][0], 4) }}</td>
                                <td>{{ round($matrix_r[$idx][1], 4) }}</td>
                                <td>{{ round($matrix_r[$idx][2], 4) }}</td>
                                <td>{{ round($matrix_r[$idx][3], 4) }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- 4. Matriks Normalisasi Terbobot (V) -->
        <div class="card electre-step">
            <div class="card-body">
                <h5 class="card-title">4. Matriks Normalisasi Terbobot (V)</h5>
                <div class="table-responsive">
                    <table class="table table-bordered table-striped w-75">
                        <thead>
                            <tr>
                                <th>Alternatif</th>
                                <th>C1</th><th>C2</th><th>C3</th><th>C4</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($alternatives as $idx => $alt)
                            <tr>
                                <td>{{ $alt['id'] }}</td>
                                <td>{{ round($matrix_v[$idx][0], 4) }}</td>
                                <td>{{ round($matrix_v[$idx][1], 4) }}</td>
                                <td>{{ round($matrix_v[$idx][2], 4) }}</td>
                                <td>{{ round($matrix_v[$idx][3], 4) }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="row">
            <!-- 5. Matriks Concordance -->
            <div class="col-md-6">
                <div class="card electre-step">
                    <div class="card-body">
                        <h5 class="card-title">5. Matriks Concordance (C)</h5>
                        <div class="table-responsive">
                            <table class="table table-bordered table-sm">
                                <thead>
                                    <tr>
                                        <th>C</th>
                                        @foreach($alternatives as $idx => $alt) <th>{{ $alt['id'] }}</th> @endforeach
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($alternatives as $k => $alt1)
                                    <tr>
                                        <th>{{ $alt1['id'] }}</th>
                                        @foreach($alternatives as $l => $alt2)
                                            <td>{{ $k == $l ? '-' : $matrix_c[$k][$l] }}</td>
                                        @endforeach
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- 6. Matriks Discordance -->
            <div class="col-md-6">
                <div class="card electre-step">
                    <div class="card-body">
                        <h5 class="card-title">6. Matriks Discordance (D)</h5>
                        <div class="table-responsive">
                            <table class="table table-bordered table-sm">
                                <thead>
                                    <tr>
                                        <th>D</th>
                                        @foreach($alternatives as $idx => $alt) <th>{{ $alt['id'] }}</th> @endforeach
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($alternatives as $k => $alt1)
                                    <tr>
                                        <th>{{ $alt1['id'] }}</th>
                                        @foreach($alternatives as $l => $alt2)
                                            <td>{{ $k == $l ? '-' : round($matrix_d[$k][$l], 4) }}</td>
                                        @endforeach
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- 7. Aggregate Dominance -->
        <div class="card electre-step">
            <div class="card-body">
                <h5 class="card-title">7. Matriks Aggregate Dominance (E)</h5>
                <p>
                    Threshold C (<u>c</u>) = {{ round($c_threshold, 4) }}<br>
                    Threshold D (<u>d</u>) = {{ round($d_threshold, 4) }}
                </p>
                <div class="table-responsive">
                    <table class="table table-bordered table-sm w-50">
                        <thead>
                            <tr>
                                <th>E</th>
                                @foreach($alternatives as $idx => $alt) <th>{{ $alt['id'] }}</th> @endforeach
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($alternatives as $k => $alt1)
                            <tr>
                                <th>{{ $alt1['id'] }}</th>
                                @foreach($alternatives as $l => $alt2)
                                    <td>{{ $k == $l ? '-' : $matrix_e[$k][$l] }}</td>
                                @endforeach
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- 8. Hasil Akhir (Ranking) -->
        <div class="card electre-step">
            <div class="card-body">
                <h4 class="card-title text-success"><i class="fas fa-trophy"></i> Kesimpulan: Ranking Produk Terlaris</h4>
                <div class="table-responsive mt-3">
                    <table class="table table-bordered table-hover table-ranking w-75">
                        <thead>
                            <tr>
                                <th>Peringkat</th>
                                <th class="text-left">Alternatif</th>
                                <th class="text-left">Nama Produk</th>
                                <th>Total Skor (Dominasi)</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($rankings as $idx => $rank)
                            <tr style="{{ $idx == 0 ? 'background-color: #d4edda; font-weight: bold;' : '' }}">
                                <td>
                                    @if($idx == 0) <i class="fas fa-medal text-warning"></i> 1
                                    @elseif($idx == 1) <i class="fas fa-medal text-secondary"></i> 2
                                    @elseif($idx == 2) <i class="fas fa-medal" style="color: #cd7f32;"></i> 3
                                    @else {{ $idx + 1 }}
                                    @endif
                                </td>
                                <td class="text-left">{{ $rank['id'] }}</td>
                                <td class="text-left">{{ $rank['nama'] }}</td>
                                <td>{{ $rank['score'] }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="alert alert-info mt-3">
                    <strong>Kesimpulan:</strong> Berdasarkan perhitungan Sistem Pendukung Keputusan (SPK) menggunakan metode ELECTRE, produk dengan peringkat terbaik adalah <strong>{{ $rankings[0]['id'] }} - {{ $rankings[0]['nama'] }}</strong>.
                </div>
            </div>
        </div>

        @endif
    </div>
</div>
@endsection