<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice #{{ str_pad($order->id, 5, '0', STR_PAD_LEFT) }} — Nyonya Crumb</title>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,400;0,600;1,400&family=DM+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }

        :root {
            --primary: #8D6E63;
            --primary-dark: #5D4037;
            --primary-light: #EFEBE9;
            --accent: #C6A68A;
            --text-dark: #3E2723;
            --text-muted: #8D6E63;
            --border: rgba(139, 94, 60, 0.15);
            --bg: #FDF9F5;
        }

        body {
            font-family: 'DM Sans', sans-serif;
            background: var(--bg);
            color: var(--text-dark);
            padding: 30px 20px;
            min-height: 100vh;
        }logo

        /* Action Bar (hidden on print) */
        .action-bar {
            max-width: 860px;
            margin: 0 auto 24px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
        }
        .action-bar-left {
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 13px;
            color: var(--text-muted);
        }
        .action-bar-left a {
            color: var(--primary);
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            font-weight: 500;
            transition: 0.2s;
        }
        .action-bar-left a:hover { color: var(--primary-dark); }
        .action-btns {
            display: flex;
            gap: 10px;
        }
        .btn-action {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 10px 20px;
            border-radius: 6px;
            font-size: 13px;
            font-weight: 600;
            cursor: pointer;
            border: none;
            transition: all 0.2s;
            text-decoration: none;
            letter-spacing: 0.5px;
        }
        .btn-print {
            background: var(--primary);
            color: #fff;
        }
        .btn-print:hover {
            background: var(--primary-dark);
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(93,64,55,0.25);
            color: #fff;
        }
        .btn-back {
            background: #fff;
            color: var(--text-dark);
            border: 1px solid var(--border);
        }
        .btn-back:hover {
            background: var(--primary-light);
        }

        /* Invoice Box */
        .invoice-box {
            max-width: 860px;
            margin: 0 auto;
            background: #fff;
            border: 1px solid var(--border);
            box-shadow: 0 8px 40px rgba(93,64,55,0.08);
        }

        /* Header */
        .inv-header {
            background: var(--primary-dark);
            padding: 40px 50px;
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
        }
        .inv-brand-name {
            font-family: 'Cormorant Garamond', serif;
            font-size: 36px;
            font-weight: 400;
            color: #FDF9F5;
            letter-spacing: 2px;
            line-height: 1;
        }
        .inv-brand-tagline {
            font-size: 11px;
            color: var(--accent);
            letter-spacing: 2px;
            text-transform: uppercase;
            margin-top: 6px;
        }
        .inv-meta {
            text-align: right;
        }
        .inv-label {
            font-size: 28px;
            font-family: 'Cormorant Garamond', serif;
            color: var(--accent);
            font-style: italic;
            letter-spacing: 1px;
        }
        .inv-number {
            font-size: 13px;
            color: rgba(253,249,245,0.7);
            margin-top: 4px;
        }
        .inv-date {
            font-size: 12px;
            color: rgba(253,249,245,0.5);
            margin-top: 2px;
        }

        /* Body */
        .inv-body {
            padding: 40px 50px;
        }

        /* Status Banner */
        .status-banner {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 8px 18px;
            border-radius: 40px;
            font-size: 12px;
            font-weight: 700;
            letter-spacing: 1px;
            text-transform: uppercase;
            margin-bottom: 36px;
        }
        .status-pending { background: #FFF8E1; color: #F57F17; }
        .status-paid { background: #E8F5E9; color: #2E7D32; }
        .status-kirim { background: #E3F2FD; color: #1565C0; }
        .status-selesai { background: var(--primary-light); color: var(--primary-dark); }
        .status-batal { background: #FFEBEE; color: #C62828; }
        .status-dot {
            width: 7px; height: 7px;
            border-radius: 50%;
            background: currentColor;
        }

        /* Info Grid */
        .inv-info-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 30px;
            margin-bottom: 36px;
            padding-bottom: 36px;
            border-bottom: 1px solid var(--border);
        }
        .inv-info-box h4 {
            font-size: 10px;
            font-weight: 700;
            letter-spacing: 2px;
            text-transform: uppercase;
            color: var(--accent);
            margin-bottom: 14px;
        }
        .inv-info-box p {
            font-size: 14px;
            line-height: 1.8;
            color: var(--text-dark);
        }
        .inv-info-box p strong { font-weight: 600; }

        /* Table */
        .inv-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 0;
        }
        .inv-table thead tr th {
            background: var(--primary-light);
            color: var(--primary-dark);
            font-size: 10px;
            font-weight: 700;
            letter-spacing: 1.5px;
            text-transform: uppercase;
            padding: 12px 16px;
            border: none;
        }
        .inv-table thead tr th:first-child { border-radius: 4px 0 0 4px; }
        .inv-table thead tr th:last-child { border-radius: 0 4px 4px 0; text-align: right; }
        .inv-table tbody tr td {
            padding: 16px;
            border-bottom: 1px solid var(--border);
            font-size: 14px;
            vertical-align: middle;
        }
        .inv-table tbody tr:last-child td { border-bottom: none; }
        .inv-table .td-right { text-align: right; }
        .inv-table .prod-img {
            width: 64px; height: 64px;
            object-fit: cover;
            border-radius: 4px;
        }
        .inv-table .no-img {
            width: 64px; height: 64px;
            background: var(--primary-light);
            border-radius: 4px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 11px;
            color: var(--text-muted);
        }
        .prod-name { font-weight: 600; margin-bottom: 3px; }
        .prod-meta { font-size: 11px; color: var(--text-muted); }

        /* Totals */
        .inv-totals {
            margin-top: 24px;
            display: flex;
            flex-direction: column;
            align-items: flex-end;
            gap: 8px;
        }
        .inv-total-row {
            display: flex;
            gap: 48px;
            font-size: 14px;
        }
        .inv-total-row .label { color: var(--text-muted); }
        .inv-total-row .val { font-weight: 600; min-width: 140px; text-align: right; }
        .inv-total-grand {
            display: flex;
            gap: 48px;
            font-size: 17px;
            font-weight: 700;
            color: var(--primary-dark);
            margin-top: 8px;
            padding-top: 16px;
            border-top: 2px solid var(--primary);
        }
        .inv-total-grand .val { min-width: 140px; text-align: right; }

        /* Footer */
        .inv-footer {
            background: var(--primary-light);
            padding: 28px 50px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .inv-footer-msg {
            font-family: 'Cormorant Garamond', serif;
            font-size: 20px;
            font-style: italic;
            color: var(--primary-dark);
        }
        .inv-footer-small {
            font-size: 11px;
            color: var(--text-muted);
            text-align: right;
        }

        /* Resi box */
        .resi-box {
            background: var(--primary-light);
            border: 1px dashed var(--accent);
            padding: 10px 16px;
            border-radius: 4px;
            display: inline-block;
            margin-top: 6px;
            font-size: 13px;
            font-weight: 700;
            letter-spacing: 1px;
            color: var(--primary-dark);
        }

        /* Print styles */
        @media print {
            body { background: #fff; padding: 0; }
            .action-bar { display: none !important; }
            .invoice-box {
                box-shadow: none;
                border: none;
                max-width: 100%;
            }
            @page {
                size: A4;
                margin: 10mm 15mm;
            }
        }
    </style>
</head>
<body>

    <!-- Action Bar -->
    <div class="action-bar no-print">
        <div class="action-bar-left">
            <a href="{{ route('backend.pesanan.index') }}">← Kembali ke Daftar Pesanan</a>
            <span>/ Invoice #{{ str_pad($order->id, 5, '0', STR_PAD_LEFT) }}</span>
        </div>
        <div class="action-btns">
            <button class="btn-action btn-print" onclick="window.print()">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 6 2 18 2 18 9"/><path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"/><rect x="6" y="14" width="12" height="8"/></svg>
                Print / Simpan PDF
            </button>
        </div>
    </div>

    <!-- Invoice -->
    <div class="invoice-box">

        <!-- Header -->
        <div class="inv-header">
            <div>
                <div class="inv-brand-name">Nyonya Crumb</div>
                <div class="inv-brand-tagline">Kue Kering Homemade Premium</div>
            </div>
            <div class="inv-meta">
                <div class="inv-label">Invoice</div>
                <div class="inv-number">#{{ str_pad($order->id, 5, '0', STR_PAD_LEFT) }}</div>
                <div class="inv-date">{{ $order->created_at->format('d F Y, H:i') }} WIB</div>
            </div>
        </div>

        <!-- Body -->
        <div class="inv-body">

            <!-- Status -->
            @php
                $statusClass = match(strtolower($order->status)) {
                    'paid' => 'status-paid',
                    'kirim' => 'status-kirim',
                    'selesai' => 'status-selesai',
                    'batal' => 'status-batal',
                    default => 'status-pending',
                };
                $statusLabel = match(strtolower($order->status)) {
                    'paid' => 'Lunas / Dibayar',
                    'kirim' => 'Dalam Pengiriman',
                    'selesai' => 'Pesanan Selesai',
                    'batal' => 'Dibatalkan',
                    default => 'Menunggu Pembayaran',
                };
            @endphp
            <span class="status-banner {{ $statusClass }}">
                <span class="status-dot"></span>
                {{ $statusLabel }}
            </span>

            <!-- Info Grid -->
            <div class="inv-info-grid">
                <div class="inv-info-box">
                    <h4>Informasi Pembeli</h4>
                    <p>
                        <strong>{{ optional(optional($order->customer)->user)->nama ?? 'Tidak tersedia' }}</strong><br>
                        {{ optional(optional($order->customer)->user)->email ?? '-' }}<br>
                        {{ optional(optional($order->customer)->user)->hp ?? '-' }}
                    </p>
                </div>
                <div class="inv-info-box">
                    <h4>Alamat Pengiriman</h4>
                    <p>
                        {{ $order->alamat ?? '-' }}
                        @if($order->pos)
                            <br>Kode Pos: {{ $order->pos }}
                        @endif
                    </p>
                    @if(!empty($order->noresi))
                        <div style="margin-top: 10px;">
                            <span style="font-size: 11px; color: var(--text-muted); letter-spacing: 1px; text-transform: uppercase;">No. Resi Pengiriman</span><br>
                            <div class="resi-box">{{ $order->noresi }}</div>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Item Table -->
            <table class="inv-table">
                <thead>
                    <tr>
                        <th style="width:80px; text-align:center;">Gambar</th>
                        <th style="text-align:left;">Produk</th>
                        <th style="text-align:center;">Harga</th>
                        <th style="text-align:center;">Qty</th>
                        <th style="text-align:right;">Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    @php $total = 0; @endphp
                    @foreach($order->orderItems as $item)
                        @php
                            $harga    = $item->harga ?? ($item->produk->harga ?? 0);
                            $qty      = $item->quantity ?? $item->jumlah ?? 1;
                            $subtotal = $harga * $qty;
                            $total   += $subtotal;
                        @endphp
                        <tr>
                            <td style="text-align:center;">
                                @if($item->produk && $item->produk->foto)
                                    <img src="{{ asset('storage/img-produk/' . $item->produk->foto) }}"
                                         class="prod-img"
                                         alt="{{ $item->produk->nama_produk }}">
                                @else
                                    <div class="no-img">No img</div>
                                @endif
                            </td>
                            <td>
                                <div class="prod-name">{{ $item->produk->nama_produk ?? '-' }}</div>
                                @if(!empty($item->size))
                                    <div class="prod-meta" style="color: var(--primary); font-weight: 600; text-transform: uppercase;">Ukuran: {{ $item->size }}</div>
                                @endif
                                <div class="prod-meta">#{{ $item->produk->kategori->nama_kategori ?? '-' }}</div>
                            </td>
                            <td style="text-align:center;">Rp {{ number_format($harga, 0, ',', '.') }}</td>
                            <td style="text-align:center;">{{ $qty }}</td>
                            <td class="td-right">Rp {{ number_format($subtotal, 0, ',', '.') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <!-- Totals -->
            <div class="inv-totals">
                <div class="inv-total-row">
                    <span class="label">Subtotal Produk</span>
                    <span class="val">Rp {{ number_format($total, 0, ',', '.') }}</span>
                </div>
                @if(!empty($order->biaya_ongkir) && $order->biaya_ongkir > 0)
                <div class="inv-total-row">
                    <span class="label">Ongkos Kirim</span>
                    <span class="val">Rp {{ number_format($order->biaya_ongkir, 0, ',', '.') }}</span>
                </div>
                @endif
                <div class="inv-total-grand">
                    <span>Total Bayar</span>
                    <span class="val">Rp {{ number_format($total + ($order->biaya_ongkir ?? 0), 0, ',', '.') }}</span>
                </div>
            </div>
        </div>

        <!-- Footer -->
        <div class="inv-footer">
            <div class="inv-footer-msg">Terima kasih atas kepercayaan Anda.</div>
            <div class="inv-footer-small">
                Nyonya Crumb · nyonyacrumb@gmail.com<br>
                Dicetak: {{ now()->format('d M Y, H:i') }} WIB
            </div>
        </div>

    </div>

</body>
</html>
