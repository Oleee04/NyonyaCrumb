<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice #{{ str_pad($order->id, 5, '0', STR_PAD_LEFT) }} — Nyonya Crumb</title>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,400;0,600;1,300;1,400&family=DM+Sans:opsz,wght@9..40,300;9..40,400;9..40,500;9..40,600;9..40,700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        *, *::before, *::after { margin: 0; padding: 0; box-sizing: border-box; }

        :root {
            --brown:      #7a6254;
            --brown-dk:   #5c4738;
            --brown-dkk:  #3e2e23;
            --brown-lt:   #c4b0a4;
            --brown-pale: #f0e9e4;
            --brown-ghost:#faf6f3;
            --ink:        #1a1108;
            --ink-2:      #3a2f28;
            --ink-3:      #7a6e68;
            --ink-4:      #b0a49e;
            --border:     #ede6e1;
            --border-md:  #d9cfc9;
            --white:      #ffffff;
            --bg:         #f5f0ec;
            --emerald:    #0d9488;
            --emerald-bg: #f0fdf9;
            --amber:      #b45309;
            --amber-bg:   #fffbeb;
            --blue:       #1d4ed8;
            --blue-bg:    #eff6ff;
            --rose:       #e11d48;
            --rose-bg:    #fff1f2;
        }

        body {
            font-family: 'DM Sans', sans-serif;
            background: var(--bg);
            color: var(--ink);
            padding: 32px 20px 56px;
            min-height: 100vh;
            -webkit-font-smoothing: antialiased;
        }

        /* ── Action bar ── */
        .action-bar {
            max-width: 820px;
            margin: 0 auto 20px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
        }
        .ab-breadcrumb {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 0.78rem;
            color: var(--ink-4);
        }
        .ab-breadcrumb a {
            color: var(--brown);
            text-decoration: none;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 5px;
            transition: color 0.18s;
        }
        .ab-breadcrumb a:hover { color: var(--brown-dk); }
        .ab-breadcrumb .sep { color: var(--ink-4); }

        .ab-actions { display: flex; gap: 10px; }
        .ab-btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 9px 20px;
            border-radius: 8px;
            font-size: 0.80rem;
            font-weight: 700;
            cursor: pointer;
            border: none;
            transition: all 0.2s ease;
            text-decoration: none;
            font-family: 'DM Sans', sans-serif;
            letter-spacing: 0.2px;
        }
        .ab-btn-print {
            background: linear-gradient(135deg, var(--brown) 0%, var(--brown-dk) 100%);
            color: #fff;
            box-shadow: 0 4px 14px rgba(92,71,56,0.35);
        }
        .ab-btn-print:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 22px rgba(92,71,56,0.45);
            color: #fff;
        }

        /* ── Invoice box ── */
        .inv-box {
            max-width: 820px;
            margin: 0 auto;
            background: var(--white);
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 20px 60px rgba(62,46,35,0.14), 0 4px 16px rgba(62,46,35,0.08);
        }

        /* ── Header ── */
        .inv-head {
            background: linear-gradient(135deg, var(--brown-dkk) 0%, var(--brown-dk) 60%, var(--brown) 100%);
            padding: 44px 50px;
            display: flex;
            justify-content: space-between;
            align-items: flex-end;
            position: relative;
            overflow: hidden;
        }
        /* Decorative circles */
        .inv-head::before {
            content: '';
            position: absolute;
            top: -60px; right: -60px;
            width: 220px; height: 220px;
            border-radius: 50%;
            background: rgba(255,255,255,0.04);
        }
        .inv-head::after {
            content: '';
            position: absolute;
            bottom: -80px; left: 30%;
            width: 300px; height: 300px;
            border-radius: 50%;
            background: rgba(255,255,255,0.03);
        }
        .inv-head > * { position: relative; z-index: 1; }

        .inv-brand-name {
            font-family: 'Cormorant Garamond', serif;
            font-size: 38px;
            font-weight: 300;
            color: #fff;
            letter-spacing: 3px;
            line-height: 1;
            margin-bottom: 8px;
        }
        .inv-brand-tagline {
            font-size: 10px;
            color: var(--brown-lt);
            letter-spacing: 3px;
            text-transform: uppercase;
        }

        .inv-head-right { text-align: right; }
        .inv-word {
            font-family: 'Cormorant Garamond', serif;
            font-size: 32px;
            font-weight: 300;
            color: var(--brown-lt);
            font-style: italic;
            letter-spacing: 2px;
            line-height: 1;
            margin-bottom: 8px;
        }
        .inv-num {
            font-size: 15px;
            font-weight: 700;
            color: #fff;
            letter-spacing: 1px;
            margin-bottom: 4px;
        }
        .inv-date-text {
            font-size: 11.5px;
            color: rgba(255,255,255,0.5);
            letter-spacing: 0.3px;
        }

        /* ── Divider bar ── */
        .inv-divider {
            height: 4px;
            background: linear-gradient(to right, var(--brown-lt), var(--brown-pale), var(--brown-lt));
        }

        /* ── Body ── */
        .inv-body { padding: 40px 50px; }

        /* Status */
        .inv-status-row { margin-bottom: 32px; }
        .inv-status {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 7px 18px;
            border-radius: 50px;
            font-size: 11.5px;
            font-weight: 700;
            letter-spacing: 1px;
            text-transform: uppercase;
        }
        .inv-status-dot { width: 7px; height: 7px; border-radius: 50%; background: currentColor; }
        .s-pending  { background: var(--amber-bg);   color: var(--amber);   border: 1px solid #fde68a; }
        .s-paid     { background: var(--emerald-bg); color: var(--emerald); border: 1px solid #6ee7b7; }
        .s-kirim    { background: var(--blue-bg);    color: var(--blue);    border: 1px solid #93c5fd; }
        .s-selesai  { background: var(--brown-pale); color: var(--brown-dk);border: 1px solid var(--brown-lt); }
        .s-batal    { background: var(--rose-bg);    color: var(--rose);    border: 1px solid #fda4af; }

        /* Info grid */
        .inv-info-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 0;
            margin-bottom: 36px;
            border: 1px solid var(--border);
            border-radius: 12px;
            overflow: hidden;
        }
        .inv-info-col {
            padding: 24px 28px;
        }
        .inv-info-col:first-child {
            border-right: 1px solid var(--border);
        }
        .inv-info-col-head {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 14px;
        }
        .inv-info-col-head i {
            width: 28px; height: 28px;
            border-radius: 7px;
            display: flex; align-items: center; justify-content: center;
            font-size: 0.85rem;
            flex-shrink: 0;
        }
        .ico-buyer  { background: var(--brown-pale); color: var(--brown-dk); }
        .ico-addr   { background: #eff6ff; color: #1d4ed8; }
        .inv-info-label {
            font-size: 9.5px;
            font-weight: 700;
            letter-spacing: 2px;
            text-transform: uppercase;
            color: var(--ink-4);
        }
        .inv-info-name {
            font-size: 15px;
            font-weight: 700;
            color: var(--ink);
            margin-bottom: 3px;
        }
        .inv-info-sub {
            font-size: 13px;
            color: var(--ink-3);
            line-height: 1.7;
        }
        .resi-chip {
            display: inline-flex;
            align-items: center;
            gap: 7px;
            margin-top: 12px;
            padding: 6px 14px;
            background: var(--brown-pale);
            border: 1px dashed var(--brown-lt);
            border-radius: 6px;
            font-size: 12.5px;
            font-weight: 700;
            letter-spacing: 1px;
            color: var(--brown-dk);
            font-family: 'Courier New', monospace;
        }
        .resi-chip i { font-size: 0.8rem; color: var(--brown); }

        /* Table */
        .inv-table-section { margin-bottom: 0; }
        .inv-table-head-row {
            display: grid;
            grid-template-columns: 72px 1fr 130px 70px 130px;
            gap: 0;
            background: var(--brown-pale);
            border-radius: 8px 8px 0 0;
            padding: 11px 16px;
            border: 1px solid var(--border);
            border-bottom: none;
        }
        .inv-table-head-row span {
            font-size: 9.5px;
            font-weight: 700;
            letter-spacing: 1.5px;
            text-transform: uppercase;
            color: var(--brown-dk);
        }
        .inv-table-head-row span.r { text-align: right; }
        .inv-table-head-row span.c { text-align: center; }

        .inv-table-body {
            border: 1px solid var(--border);
            border-radius: 0 0 8px 8px;
            overflow: hidden;
        }
        .inv-item-row {
            display: grid;
            grid-template-columns: 72px 1fr 130px 70px 130px;
            gap: 0;
            align-items: center;
            padding: 16px;
            border-bottom: 1px solid var(--border);
            transition: background 0.14s ease;
        }
        .inv-item-row:last-child { border-bottom: none; }
        .inv-item-row:hover { background: var(--brown-ghost); }

        .inv-item-img img {
            width: 56px; height: 56px;
            border-radius: 8px;
            object-fit: cover;
            border: 1px solid var(--border);
            display: block;
        }
        .inv-item-img-empty {
            width: 56px; height: 56px;
            border-radius: 8px;
            background: var(--brown-pale);
            border: 1px solid var(--border);
            display: flex; align-items: center; justify-content: center;
            color: var(--ink-4);
            font-size: 1.1rem;
        }
        .inv-item-name {
            font-size: 14px;
            font-weight: 700;
            color: var(--ink);
            margin-bottom: 4px;
        }
        .inv-item-size {
            display: inline-flex;
            align-items: center;
            font-size: 10px;
            font-weight: 700;
            padding: 2px 8px;
            background: #fce7f3;
            color: #9d174d;
            border-radius: 50px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 3px;
            margin-right: 4px;
        }
        .inv-item-cat {
            display: inline-flex;
            font-size: 10px;
            font-weight: 500;
            padding: 2px 8px;
            background: var(--brown-pale);
            color: var(--brown-dk);
            border-radius: 50px;
        }
        .inv-item-price {
            font-size: 13.5px;
            color: var(--ink-2);
            text-align: right;
        }
        .inv-item-qty {
            text-align: center;
        }
        .inv-qty-bubble {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 30px; height: 30px;
            background: var(--brown-pale);
            color: var(--brown-dk);
            border-radius: 50%;
            font-size: 13px;
            font-weight: 700;
        }
        .inv-item-subtotal {
            font-size: 14px;
            font-weight: 700;
            color: var(--ink);
            text-align: right;
        }

        /* Totals */
        .inv-totals-wrap {
            margin-top: 24px;
            display: flex;
            justify-content: flex-end;
        }
        .inv-totals-box {
            width: 320px;
        }
        .inv-total-line {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 9px 0;
            border-bottom: 1px solid var(--border);
            font-size: 13.5px;
        }
        .inv-total-line:last-of-type { border-bottom: none; }
        .inv-total-line .tl-label { color: var(--ink-3); }
        .inv-total-line .tl-val { font-weight: 600; color: var(--ink); }
        .inv-grand {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 14px 20px;
            background: linear-gradient(135deg, var(--brown-pale), #e8ddd7);
            border: 1px solid var(--border-md);
            border-radius: 10px;
            margin-top: 12px;
        }
        .inv-grand-label {
            font-size: 13px;
            font-weight: 700;
            color: var(--brown-dk);
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .inv-grand-val {
            font-family: 'Cormorant Garamond', serif;
            font-size: 22px;
            font-weight: 700;
            color: var(--brown-dkk);
        }

        /* Footer */
        .inv-foot {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 28px 50px;
            background: linear-gradient(135deg, var(--brown-pale) 0%, #e8ddd7 100%);
            border-top: 1px solid var(--border-md);
            margin-top: 40px;
        }
        .inv-foot-left {}
        .inv-foot-msg {
            font-family: 'Cormorant Garamond', serif;
            font-size: 20px;
            font-style: italic;
            color: var(--brown-dk);
            margin-bottom: 4px;
        }
        .inv-foot-sub {
            font-size: 11px;
            color: var(--ink-4);
        }
        .inv-foot-right { text-align: right; }
        .inv-foot-brand {
            font-family: 'Cormorant Garamond', serif;
            font-size: 16px;
            font-weight: 600;
            color: var(--brown-dk);
            letter-spacing: 1px;
            margin-bottom: 3px;
        }
        .inv-foot-contact { font-size: 11px; color: var(--ink-4); line-height: 1.6; }

        /* Print */
        @media print {
            body { background: #fff; padding: 0; }
            .action-bar { display: none !important; }
            .inv-box {
                box-shadow: none;
                border-radius: 0;
                max-width: 100%;
            }
            @page { size: A4; margin: 10mm 12mm; }
        }
    </style>
</head>
<body>

    <!-- Action Bar -->
    <div class="action-bar no-print">
        <div class="ab-breadcrumb">
            <a href="{{ route('backend.pesanan.index') }}">
                <i class="fa fa-arrow-left"></i> Daftar Pesanan
            </a>
            <span class="sep">/</span>
            <span>Invoice #{{ str_pad($order->id, 5, '0', STR_PAD_LEFT) }}</span>
        </div>
        <div class="ab-actions">
            <button class="ab-btn ab-btn-print" onclick="window.print()">
                <i class="fa fa-print"></i> Print / Simpan PDF
            </button>
        </div>
    </div>

    <!-- Invoice -->
    <div class="inv-box">

        <!-- Header -->
        <div class="inv-head">
            <div>
                <div class="inv-brand-name">Nyonya Crumb</div>
                <div class="inv-brand-tagline">Kue Kering Homemade Premium</div>
            </div>
            <div class="inv-head-right">
                <div class="inv-word">Invoice</div>
                <div class="inv-num">#{{ str_pad($order->id, 5, '0', STR_PAD_LEFT) }}</div>
                <div class="inv-date-text">{{ $order->created_at->format('d F Y, H:i') }} WIB</div>
            </div>
        </div>

        <!-- Divider -->
        <div class="inv-divider"></div>

        <!-- Body -->
        <div class="inv-body">

            <!-- Status -->
            @php
                $statusClass = match(strtolower($order->status)) {
                    'paid'    => 's-paid',
                    'kirim'   => 's-kirim',
                    'selesai' => 's-selesai',
                    'batal'   => 's-batal',
                    default   => 's-pending',
                };
                $statusLabel = match(strtolower($order->status)) {
                    'paid'    => 'Lunas · Dibayar',
                    'kirim'   => 'Dalam Pengiriman',
                    'selesai' => 'Pesanan Selesai',
                    'batal'   => 'Dibatalkan',
                    default   => 'Menunggu Pembayaran',
                };
            @endphp
            <div class="inv-status-row">
                <span class="inv-status {{ $statusClass }}">
                    <span class="inv-status-dot"></span>
                    {{ $statusLabel }}
                </span>
            </div>

            <!-- Info Grid -->
            <div class="inv-info-grid">
                <div class="inv-info-col">
                    <div class="inv-info-col-head">
                        <i class="fa fa-user ico-buyer inv-info-col-head-ico" style="width:28px;height:28px;background:var(--brown-pale);color:var(--brown-dk);border-radius:7px;display:flex;align-items:center;justify-content:center;font-size:0.8rem;"></i>
                        <span class="inv-info-label">Informasi Pembeli</span>
                    </div>
                    <p class="inv-info-name">{{ optional(optional($order->customer)->user)->nama ?? 'Tidak tersedia' }}</p>
                    <div class="inv-info-sub">
                        {{ optional(optional($order->customer)->user)->email ?? '-' }}<br>
                        {{ $order->hp ?? optional(optional($order->customer)->user)->hp ?? '-' }}
                    </div>
                </div>
                <div class="inv-info-col">
                    <div class="inv-info-col-head">
                        <i class="fa fa-location-dot" style="width:28px;height:28px;background:#eff6ff;color:#1d4ed8;border-radius:7px;display:flex;align-items:center;justify-content:center;font-size:0.8rem;"></i>
                        <span class="inv-info-label">Alamat Pengiriman</span>
                    </div>
                    <div class="inv-info-sub">
                        {{ $order->alamat ?? '-' }}
                        @if($order->pos)
                            <br><strong style="color:var(--ink-2);">Kode Pos:</strong> {{ $order->pos }}
                        @endif
                    </div>
                    @if(!empty($order->noresi))
                        <div style="margin-top:12px;">
                            <div style="font-size:9.5px;font-weight:700;letter-spacing:1.5px;text-transform:uppercase;color:var(--ink-4);margin-bottom:6px;">No. Resi Pengiriman</div>
                            <span class="resi-chip">
                                <i class="fa fa-barcode"></i>
                                {{ $order->noresi }}
                            </span>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Table Header -->
            <div class="inv-table-section">
                <div class="inv-table-head-row">
                    <span></span>
                    <span>Produk</span>
                    <span class="r">Harga Satuan</span>
                    <span class="c">Qty</span>
                    <span class="r">Subtotal</span>
                </div>
                <div class="inv-table-body">
                    @php $grandTotal = 0; @endphp
                    @foreach($order->orderItems as $item)
                        @php
                            $harga    = $item->harga ?? ($item->produk->harga ?? 0);
                            $qty      = $item->quantity ?? $item->jumlah ?? 1;
                            $subtotal = $harga * $qty;
                            $grandTotal += $subtotal;
                        @endphp
                        <div class="inv-item-row">
                            <div class="inv-item-img">
                                @if($item->produk && $item->produk->foto)
                                    <img src="{{ asset('storage/img-produk/' . $item->produk->foto) }}"
                                         alt="{{ $item->produk->nama_produk }}">
                                @else
                                    <div class="inv-item-img-empty"><i class="fa fa-image"></i></div>
                                @endif
                            </div>
                            <div>
                                <p class="inv-item-name">{{ $item->produk->nama_produk ?? '-' }}</p>
                                <div>
                                    @if(!empty($item->size))
                                        <span class="inv-item-size">{{ $item->size }}</span>
                                    @endif
                                    @if($item->produk->kategori->nama_kategori ?? false)
                                        <span class="inv-item-cat">#{{ $item->produk->kategori->nama_kategori }}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="inv-item-price">Rp {{ number_format($harga, 0, ',', '.') }}</div>
                            <div class="inv-item-qty">
                                <span class="inv-qty-bubble">{{ $qty }}</span>
                            </div>
                            <div class="inv-item-subtotal">Rp {{ number_format($subtotal, 0, ',', '.') }}</div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Totals -->
            <div class="inv-totals-wrap">
                <div class="inv-totals-box">
                    <div class="inv-total-line">
                        <span class="tl-label">Subtotal Produk</span>
                        <span class="tl-val">Rp {{ number_format($grandTotal, 0, ',', '.') }}</span>
                    </div>
                    @if(!empty($order->biaya_ongkir) && $order->biaya_ongkir > 0)
                    <div class="inv-total-line">
                        <span class="tl-label">Ongkos Kirim</span>
                        <span class="tl-val" style="color:#c2410c;">Rp {{ number_format($order->biaya_ongkir, 0, ',', '.') }}</span>
                    </div>
                    @endif
                    <div class="inv-grand">
                        <span class="inv-grand-label">Total Bayar</span>
                        <span class="inv-grand-val">Rp {{ number_format($grandTotal + ($order->biaya_ongkir ?? 0), 0, ',', '.') }}</span>
                    </div>
                </div>
            </div>

        </div>

        <!-- Footer -->
        <div class="inv-foot">
            <div class="inv-foot-left">
                <div class="inv-foot-msg">Terima kasih atas kepercayaan Anda.</div>
                <div class="inv-foot-sub">Dicetak: {{ now()->format('d M Y, H:i') }} WIB</div>
            </div>
            <div class="inv-foot-right">
                <div class="inv-foot-brand">Nyonya Crumb</div>
                <div class="inv-foot-contact">
                    nyonyacrumb@gmail.com<br>
                    Kue Kering Homemade Premium
                </div>
            </div>
        </div>

    </div>

</body>
</html>
