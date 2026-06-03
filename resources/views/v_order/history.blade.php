@extends('v_layouts.app')

@section('content')
<style>
    .history-section {
        padding: 160px 0 100px;
        min-height: 80vh;
    }

    .section-header {
        text-align: center;
        margin-bottom: 50px;
    }

    .section-title {
        font-family: 'Cormorant Garamond', serif;
        font-size: 42px;
        font-weight: 600;
        color: var(--text-dark);
        margin-bottom: 10px;
    }

    .section-subtitle {
        color: var(--text-muted);
        font-size: 14px;
        letter-spacing: 2px;
        text-transform: uppercase;
    }

    .history-card {
        background: var(--bg-white);
        border: 1px solid var(--border);
        padding: 40px;
    }

    .table-nc {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
    }

    .table-nc th {
        text-align: left;
        font-size: 11px;
        text-transform: uppercase;
        letter-spacing: 1px;
        color: var(--text-muted);
        padding: 15px 20px;
        border-bottom: 1px solid var(--border);
        font-weight: 600;
    }

    .table-nc td {
        padding: 20px;
        font-size: 14px;
        color: var(--text-dark);
        border-bottom: 1px solid var(--border-light);
        vertical-align: middle;
    }

    .badge-nc {
        padding: 4px 12px;
        font-size: 10px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .badge-paid { background: #E8F5E9; color: #2E7D32; }
    .badge-shipped { background: #FFF3E0; color: #E65100; }
    .badge-completed { background: #E3F2FD; color: #1565C0; }
    .badge-default { background: var(--bg-creme); color: var(--text-muted); }

    .btn-nc-sm {
        padding: 8px 16px;
        font-size: 11px;
        text-transform: uppercase;
        letter-spacing: 1px;
        font-weight: 600;
        border: 1px solid var(--border);
        background: transparent;
        color: var(--text-dark);
        text-decoration: none;
        transition: 0.3s;
        display: inline-block;
        margin-right: 5px;
    }

    .btn-nc-sm:hover {
        background: var(--text-dark);
        color: white;
        border-color: var(--text-dark);
    }

    @media (max-width: 768px) {
        .history-section { padding: 180px 0 60px; }
        .history-card { padding: 20px; }
        .table-responsive { border: 0; }
    }
</style>

<div class="history-section">
    <div class="container">
        <div class="section-header reveal">
            <span class="section-subtitle">Aktivitas Pesanan</span>
            <h1 class="section-title">Riwayat <i>Belanja</i></h1>
        </div>

        <div class="history-card reveal">
            @if(session()->has('success'))
                <div class="alert alert-success mb-4" style="border-radius: 0; border: none; background: #E8F5E9; color: #2E7D32; font-size: 14px;">
                    {{ session('success') }}
                </div>
            @endif

            <div class="table-responsive">
                <table class="table-nc">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Tanggal</th>
                            <th>Total Pembayaran</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($orders as $index => $order)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $order->created_at->format('d M Y') }}<br><small class="text-muted">{{ $order->created_at->format('H:i') }}</small></td>
                                <td style="font-weight: 600; color: var(--primary);">Rp {{ number_format($order->total_harga + $order->biaya_ongkir, 0, ',', '.') }}</td>
                                <td>
                                    @switch($order->status)
                                        @case('Paid')
                                            <span class="badge-nc badge-paid">Dibayar</span>
                                            @break
                                        @case('Kirim')
                                            <span class="badge-nc badge-shipped">Dikirim</span>
                                            @break
                                        @case('Selesai')
                                            <span class="badge-nc badge-completed">Selesai</span>
                                            @break
                                        @default
                                            <span class="badge-nc badge-default">{{ $order->status }}</span>
                                    @endswitch
                                </td>
                                <td>
                                    @if (Route::has('order.detail'))
                                        <a href="{{ route('order.detail', $order->id) }}" class="btn-nc-sm">Detail</a>
                                    @endif
                                    @if (Route::has('order.invoice'))
                                        <a href="{{ route('order.invoice', $order->id) }}" class="btn-nc-sm">Invoice</a>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-5">
                                    <p class="text-muted">Belum ada riwayat pesanan.</p>
                                    <a href="{{ route('produk.all') }}" class="btn-nc-sm" style="margin-top: 15px;">Mulai Belanja</a>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
