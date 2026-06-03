@extends('backend.v_layouts.app')
@section('content')
        <!-- Page Header -->
        <div class="page-header fade-up">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('backend.beranda') }}">Dashboard</a></li>
                    <li class="breadcrumb-sep">›</li>
                    <li class="breadcrumb-item">Beranda</li>
                </ol>
            </nav>
            <h1 class="page-title">Selamat datang kembali ✦</h1>
            <p class="page-subtitle">{{ \Carbon\Carbon::now()->translatedFormat('l, d F Y') }} — Semoga hari Anda penuh manisnya Nyonya Crumb</p>
        </div>

        <!-- Stat Cards -->
        <div class="grid-4 fade-up" style="animation-delay:0.05s;">

            <div class="stat-card">
                <div class="stat-icon-outer brand">
                    <i class="ri-shopping-bag-3-line"></i>
                </div>
                <div class="stat-content">
                    <div class="stat-val">Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</div>
                    <div class="stat-label">Total Penjualan</div>
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-icon-outer emerald">
                    <i class="ri-shopping-cart-2-line"></i>
                </div>
                <div class="stat-content">
                    <div class="stat-val">{{ $totalPesananSelesai }}</div>
                    <div class="stat-label">Pesanan Selesai</div>
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-icon-outer amber">
                    <i class="ri-user-star-line"></i>
                </div>
                <div class="stat-content">
                    <div class="stat-val">{{ $totalCustomer }}</div>
                    <div class="stat-label">Pelanggan Aktif</div>
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-icon-outer rose">
                    <i class="ri-cake-3-line"></i>
                </div>
                <div class="stat-content">
                    <div class="stat-val">{{ $totalProduk }}</div>
                    <div class="stat-label">Produk Tersedia</div>
                </div>
            </div>

        </div>

        <!-- Main content row -->
        <div class="grid-2 fade-up" style="animation-delay:0.1s;">

            <!-- Recent Orders -->
            <div class="card">
                <div class="card-header">
                    <span class="card-header-title">
                        <i class="ri-list-check-3" style="color:var(--brand);margin-right:6px;"></i>
                        Pesanan Terbaru
                    </span>
                    <a href="{{ route('backend.pesanan.index') }}" class="btn btn-sm btn-outline">Lihat Semua</a>
                </div>
                <div class="card-body" style="padding:0;">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Pelanggan</th>
                                <th>Tanggal</th>
                                <th>Total</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($recentOrders as $order)
                            <tr>
                                <td>
                                    <div style="display:flex;align-items:center;gap:10px;">
                                        <div class="demo-avatar" style="text-transform:uppercase;">
                                            {{ substr($order->customer->user->nama ?? 'G', 0, 2) }}
                                        </div>
                                        <span>{{ $order->customer->user->nama ?? 'Guest' }}</span>
                                    </div>
                                </td>
                                <td>{{ $order->created_at->format('d M Y') }}</td>
                                <td style="font-weight:600;">Rp {{ number_format($order->total_harga ?? 0, 0, ',', '.') }}</td>
                                <td>
                                    @if($order->status == 'Selesai')
                                        <span class="badge badge-success">Selesai</span>
                                    @elseif($order->status == 'Proses')
                                        <span class="badge badge-warning">Proses</span>
                                    @elseif($order->status == 'Batal')
                                        <span class="badge badge-danger">Batal</span>
                                    @else
                                        <span class="badge badge-info">{{ $order->status }}</span>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                            @if($recentOrders->isEmpty())
                            <tr>
                                <td colspan="4" style="text-align:center;color:var(--ink-4);padding:24px;">Belum ada pesanan terbaru.</td>
                            </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Top Products -->
            <div class="card">
                <div class="card-header">
                    <span class="card-header-title">
                        <i class="ri-trophy-line" style="color:var(--brand);margin-right:6px;"></i>
                        Produk Terlaris
                    </span>
                </div>
                <div class="card-body">
                    <div class="product-list">
                        @php
                            $colors = ['brand', 'emerald', 'amber', 'rose', 'blue'];
                            $bgColors = ['brand-pale', 'emerald-bg', 'amber-bg', 'rose-bg', 'blue-bg'];
                            $textColors = ['brand-dk', 'emerald', '#b45309', 'rose', 'blue'];
                            $icons = ['🥖', '🧁', '🍞', '🥐', '🥯'];
                            $maxQty = $topProducts->max('total_qty') ?: 1;
                        @endphp
                        @foreach($topProducts as $index => $produk)
                        @php
                            $cIdx = $index % count($colors);
                            $color = $colors[$cIdx];
                            $bgColor = $bgColors[$cIdx];
                            $textColor = $textColors[$cIdx];
                            $icon = $icons[$cIdx];
                            $percentage = ($produk->total_qty / $maxQty) * 100;
                        @endphp
                        <div class="product-item">
                            <div class="product-img" style="background: var(--{{ $bgColor }});">
                                @if(isset($produk->foto) && $produk->foto)
                                    <img src="{{ asset('storage/img-produk/' . $produk->foto) }}" alt="foto" style="width:100%;height:100%;object-fit:cover;">
                                @else
                                    <span style="font-size: 1.2rem;">{{ $icon }}</span>
                                @endif
                            </div>
                            <div class="product-info">
                                <div class="product-name">{{ $produk->nama_produk }}</div>
                                <div class="mini-progress">
                                    <div class="mini-progress-bar" style="width:{{ $percentage }}%; background: {{ in_array($color, ['brand', 'emerald', 'rose', 'blue']) ? 'var(--'.$color.')' : '#d97706' }};"></div>
                                </div>
                            </div>
                            <div class="product-stat" style="color: {{ strpos($textColor, '#') === 0 ? $textColor : 'var(--'.$textColor.')' }};">
                                {{ $produk->total_qty }} <span style="font-size: 0.7rem; opacity: 0.7; font-weight: 500;">Terjual</span>
                            </div>
                        </div>
                        @endforeach
                        @if($topProducts->isEmpty())
                            <div style="text-align:center;color:var(--ink-4);padding:24px;">Belum ada data produk terlaris.</div>
                        @endif
                    </div>
                </div>
            </div>

        </div>

        <footer class="footer">
            © {{ date('Y') }} Nyonya Crumb · Artisan Bakery Admin Panel · Crafted with care
        </footer>
@endsection