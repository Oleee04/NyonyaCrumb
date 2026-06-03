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
        }

        /* Action Bar */
        .action-bar {
            max-width: 860px;
            margin: 0 auto 24px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        .action-bar-left a {
            color: var(--primary);
            text-decoration: none;
            font-size: 13px;
            font-weight: 500;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }
        .action-bar-left a:hover { color: var(--primary-dark); }
        .btn-action {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 10px 22px;
            border-radius: 6px;
            font-size: 13px;
            font-weight: 600;
            cursor: pointer;
            border: none;
            transition: all 0.2s;
            background: var(--primary);
            color: #fff;
            letter-spacing: 0.5px;
        }
        .btn-action:hover {
            background: var(--primary-dark);
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(93,64,55,0.25);
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
        }
        .inv-brand-tagline {
            font-size: 11px;
            color: var(--accent);
            letter-spacing: 2px;
            text-transform: uppercase;
            margin-top: 6px;
        }
        .inv-meta { text-align: right; }
        .inv-label {
            font-size: 28px;
            font-family: 'Cormorant Garamond', serif;
            color: var(--accent);
            font-style: italic;
        }
        .inv-number { font-size: 13px; color: rgba(253,249,245,0.7); margin-top: 4px; }
        .inv-date   { font-size: 12px; color: rgba(253,249,245,0.5); margin-top: 2px; }

        /* Body */
        .inv-body { padding: 40px 50px; }

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
        .inv-info-box p { font-size: 14px; line-height: 1.8; }

        /* Table */
        .inv-table { width: 100%; border-collapse: collapse; }
        .inv-table th {
            background: var(--primary-light);
            color: var(--primary-dark);
            font-size: 10px;
            font-weight: 700;
            letter-spacing: 1.5px;
            text-transform: uppercase;
            padding: 12px 16px;
            border: none;
        }
        .inv-table td {
            padding: 16px;
            border-bottom: 1px solid var(--border);
            font-size: 14px;
            vertical-align: middle;
        }
        .inv-table tbody tr:last-child td { border-bottom: none; }
        .prod-img { width: 60px; height: 60px; object-fit: cover; border-radius: 4px; }
        .prod-name { font-weight: 600; }
        .prod-meta { font-size: 11px; color: var(--text-muted); margin-top: 2px; }

        /* Totals */
        .inv-totals {
            margin-top: 24px;
            display: flex;
            flex-direction: column;
            align-items: flex-end;
            gap: 8px;
        }
        .inv-total-row { display: flex; gap: 48px; font-size: 14px; }
        .inv-total-row .label { color: var(--text-muted); }
        .inv-total-row .val  { font-weight: 600; min-width: 140px; text-align: right; }
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
        .inv-footer-small { font-size: 11px; color: var(--text-muted); text-align: right; }

        @media print {
            body { background: #fff; padding: 0; }
            .action-bar { display: none !important; }
            .invoice-box { box-shadow: none; border: none; max-width: 100%; }
            @page { size: A4; margin: 10mm 15mm; }
        }
    </style>
</head>
<body>

    <!-- Action Bar -->
    <div class="action-bar">
        <div class="action-bar-left">
            <a href="{{ url()->previous() }}">← Kembali</a>
        </div>
        <button class="btn-action" onclick="window.print()">
            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                <polyline points="6 9 6 2 18 2 18 9"/>
                <path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"/>
                <rect x="6" y="14" width="12" height="8"/>
            </svg>
            Print / Simpan PDF
        </button>
    </div>

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

            <!-- Info Grid -->
            <div class="inv-info-grid">
                <div class="inv-info-box">
                    <h4>Informasi Pembeli</h4>
                    <p>
                        <strong>{{ $order->customer->user->name ?? 'N/A' }}</strong><br>
                        {{ $order->customer->user->email ?? '-' }}<br>
                        {{ $order->customer->user->hp ?? '-' }}
                    </p>
                </div>
                <div class="inv-info-box">
                    <h4>Alamat Pengiriman</h4>
                    <p>{{ $order->alamat ?? '-' }}</p>
                </div>
            </div>

            <!-- Table -->
            <table class="inv-table">
                <thead>
                    <tr>
                        <th style="text-align:center;">Produk</th>
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
                            <td>
                                <div class="prod-name">{{ $item->produk->nama_produk ?? '-' }}</div>
                                @if(!empty($item->size))
                                    <div class="prod-meta">Ukuran: {{ strtoupper($item->size) }}</div>
                                @endif
                            </td>
                            <td style="text-align:center;">Rp {{ number_format($harga, 0, ',', '.') }}</td>
                            <td style="text-align:center;">{{ $qty }}</td>
                            <td style="text-align:right;">Rp {{ number_format($subtotal, 0, ',', '.') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <!-- Totals -->
            <div class="inv-totals">
                <div class="inv-total-row">
                    <span class="label">Subtotal</span>
                    <span class="val">Rp {{ number_format($total, 0, ',', '.') }}</span>
                </div>
                <div class="inv-total-row">
                    <span class="label">Ongkos Kirim</span>
                    <span class="val">Rp {{ number_format($order->biaya_ongkir ?? 0, 0, ',', '.') }}</span>
                </div>
                <div class="inv-total-grand">
                    <span>Total Bayar</span>
                    <span class="val">Rp {{ number_format($total + ($order->biaya_ongkir ?? 0), 0, ',', '.') }}</span>
                </div>
            </div>
        </div>

        <!-- Footer -->
        <div class="inv-footer">
            <div class="inv-footer-msg">Terima kasih telah berbelanja!</div>
            <div class="inv-footer-small">
                Nyonya Crumb &middot; nyonyacrumb@gmail.com<br>
                Dicetak: {{ now()->format('d M Y, H:i') }} WIB
            </div>
        </div>
    </div>

</body>
</html>
