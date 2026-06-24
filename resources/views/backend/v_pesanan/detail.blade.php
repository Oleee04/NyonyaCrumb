@extends('backend.v_layouts.app')

@section('content')

<style>
/* ══════════════════════════════════════════
   DETAIL PESANAN – CUSTOM STYLES
══════════════════════════════════════════ */

/* ── Page header ── */
.dp-back {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    font-size: 0.78rem;
    font-weight: 600;
    color: var(--ink-3);
    text-decoration: none;
    padding: 5px 12px 5px 6px;
    border-radius: var(--r-lg);
    transition: all 0.18s ease;
    margin-bottom: 18px;
}
.dp-back i { font-size: 1.1rem; }
.dp-back:hover { background: var(--surface-2); color: var(--brand-dk); }

.dp-hero {
    display: flex;
    align-items: center;
    justify-content: space-between;
    flex-wrap: wrap;
    gap: 14px;
    margin-bottom: 28px;
}
.dp-hero-left {
    display: flex;
    align-items: center;
    gap: 14px;
}
.dp-id-badge {
    background: linear-gradient(135deg, var(--brand) 0%, var(--brand-dk) 100%);
    color: #fff;
    font-family: 'Cormorant Garamond', serif;
    font-size: 1.1rem;
    font-weight: 700;
    letter-spacing: 1px;
    padding: 8px 16px;
    border-radius: var(--r-lg);
    box-shadow: var(--sh-brand);
    white-space: nowrap;
    flex-shrink: 0;
}
.dp-title {
    font-family: 'Cormorant Garamond', serif;
    font-size: 1.8rem;
    font-weight: 400;
    color: var(--ink);
    margin: 0 0 3px;
    line-height: 1.1;
}
.dp-date {
    display: flex;
    align-items: center;
    gap: 6px;
    font-size: 0.74rem;
    color: var(--ink-4);
    margin: 0;
}
.dp-date i { font-size: 0.85rem; }

/* Status pill */
.dp-status {
    display: inline-flex;
    align-items: center;
    gap: 7px;
    font-size: 0.80rem;
    font-weight: 600;
    padding: 7px 16px;
    border-radius: 50px;
    flex-shrink: 0;
}
.dp-status i { font-size: 0.95rem; }
.dp-s-pending  { background: #fffbeb; color: #b45309; border: 1px solid #fde68a; }
.dp-s-paid     { background: #f0fdf9; color: #0d9488; border: 1px solid #6ee7b7; }
.dp-s-kirim    { background: #eff6ff; color: #1d4ed8; border: 1px solid #93c5fd; }
.dp-s-selesai  { background: var(--brand-pale); color: var(--brand-dk); border: 1px solid var(--brand-lt); }

/* ── Alert ── */
.dp-alert {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 12px 16px;
    border-radius: var(--r-lg);
    margin-bottom: 22px;
    font-size: 0.83rem;
    font-weight: 500;
    background: #f0fdf9;
    color: #0d9488;
    border: 1px solid #6ee7b7;
}
.dp-alert i { font-size: 1.1rem; flex-shrink: 0; }
.dp-alert-close {
    margin-left: auto;
    background: none;
    border: none;
    color: currentColor;
    cursor: pointer;
    font-size: 1rem;
    opacity: 0.6;
    line-height: 1;
    padding: 0;
}
.dp-alert-close:hover { opacity: 1; }

/* ── Grid ── */
.dp-grid {
    display: grid;
    grid-template-columns: 1fr 320px;
    gap: 20px;
    align-items: start;
}
@media (max-width: 1100px) {
    .dp-grid { grid-template-columns: 1fr; }
}

/* ── Card ── */
.dp-card {
    background: var(--white);
    border: 1px solid var(--border);
    border-radius: var(--r-xl);
    box-shadow: 0 2px 14px -5px rgba(43,31,24,0.08);
    overflow: hidden;
    margin-bottom: 20px;
}
.dp-card-head {
    display: flex;
    align-items: center;
    gap: 11px;
    padding: 16px 20px;
    border-bottom: 1px solid var(--border);
    background: var(--brand-ghost);
}
.dp-card-ico {
    width: 34px; height: 34px;
    border-radius: var(--r-md);
    display: flex; align-items: center; justify-content: center;
    font-size: 1rem;
    flex-shrink: 0;
}
.dp-card-ico.brand   { background: var(--brand-pale);  color: var(--brand-dk); }
.dp-card-ico.orange  { background: #fff7ed;             color: #c2410c; }
.dp-card-ico.green   { background: #f0fdf9;             color: #0d9488; }
.dp-card-ico.blue    { background: #eff6ff;             color: #1d4ed8; }
.dp-card-ico.purple  { background: #faf5ff;             color: #7c3aed; }

.dp-card-title {
    font-size: 0.88rem;
    font-weight: 700;
    color: var(--ink);
    margin: 0;
    flex: 1;
}
.dp-card-badge {
    font-size: 0.68rem;
    font-weight: 700;
    background: var(--brand-pale);
    color: var(--brand-dk);
    padding: 2px 10px;
    border-radius: 50px;
}
.dp-card-body { padding: 20px; }
.dp-card-body.p-0 { padding: 0; }

/* ── Customer ── */
.dp-customer-profile {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 14px;
    background: linear-gradient(135deg, var(--brand-ghost), var(--brand-pale));
    border: 1px solid var(--border);
    border-radius: var(--r-lg);
    margin-bottom: 18px;
}
.dp-avatar {
    width: 46px; height: 46px;
    border-radius: 50%;
    background: linear-gradient(135deg, var(--brand), var(--brand-dk));
    color: #fff;
    font-family: 'Cormorant Garamond', serif;
    font-size: 1.3rem;
    font-weight: 700;
    display: flex; align-items: center; justify-content: center;
    flex-shrink: 0;
    box-shadow: var(--sh-brand);
}
.dp-cust-name { font-size: 0.92rem; font-weight: 700; color: var(--ink); margin: 0 0 2px; }
.dp-cust-email { font-size: 0.74rem; color: var(--ink-3); margin: 0; }

.dp-info-list { display: flex; flex-direction: column; gap: 12px; }
.dp-info-row { display: flex; align-items: flex-start; gap: 11px; }
.dp-info-ico {
    width: 32px; height: 32px;
    border-radius: var(--r-md);
    background: var(--surface-2);
    border: 1px solid var(--border);
    display: flex; align-items: center; justify-content: center;
    color: var(--brand);
    font-size: 0.95rem;
    flex-shrink: 0;
    margin-top: 2px;
}
.dp-info-label { font-size: 0.66rem; font-weight: 700; color: var(--ink-4); text-transform: uppercase; letter-spacing: 0.8px; margin: 0 0 2px; }
.dp-info-val { font-size: 0.83rem; font-weight: 500; color: var(--ink-2); margin: 0; line-height: 1.4; }
.dp-info-sub { font-size: 0.72rem; color: var(--ink-4); margin: 2px 0 0; }

/* ── Products table ── */
.dp-table-wrap { overflow-x: auto; }
.dp-table {
    width: 100%;
    border-collapse: collapse;
}
.dp-table thead tr {
    background: var(--surface-2);
    border-bottom: 1px solid var(--border);
}
.dp-table thead th {
    padding: 11px 14px;
    font-size: 0.65rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 1px;
    color: var(--ink-3);
    white-space: nowrap;
}
.dp-table th.r, .dp-table td.r { text-align: right; }
.dp-table th.c, .dp-table td.c { text-align: center; }

.dp-prod-row {
    border-bottom: 1px solid var(--border);
    transition: background 0.14s ease;
}
.dp-prod-row:hover { background: var(--brand-ghost); }
.dp-prod-row:last-child { border-bottom: none; }

.dp-prod-row td { padding: 12px 14px; vertical-align: middle; }
.dp-prod-row td:first-child { padding-left: 14px; width: 68px; }

.dp-thumb {
    width: 52px; height: 52px;
    border-radius: var(--r-md);
    object-fit: cover;
    border: 1px solid var(--border);
    display: block;
}
.dp-thumb-empty {
    width: 52px; height: 52px;
    border-radius: var(--r-md);
    background: var(--surface-2);
    border: 1px solid var(--border);
    display: flex; align-items: center; justify-content: center;
    color: var(--ink-4);
    font-size: 1.1rem;
}
.dp-prod-name { font-size: 0.86rem; font-weight: 700; color: var(--ink); margin: 0 0 5px; }
.dp-prod-tags { display: flex; flex-wrap: wrap; gap: 4px; margin-bottom: 4px; }
.dp-tag {
    font-size: 0.62rem;
    font-weight: 700;
    padding: 2px 7px;
    border-radius: 50px;
    line-height: 1.5;
}
.dp-tag-size { background: #fce7f3; color: #9d174d; text-transform: uppercase; letter-spacing: 0.5px; }
.dp-tag-cat  { background: var(--surface-2); color: var(--ink-3); border: 1px solid var(--border); }
.dp-prod-meta { font-size: 0.68rem; color: var(--ink-4); margin: 0; }

.dp-price { font-size: 0.82rem; color: var(--ink-2); white-space: nowrap; }
.dp-qty {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 26px; height: 26px;
    background: var(--brand-pale);
    color: var(--brand-dk);
    border-radius: 50%;
    font-size: 0.80rem;
    font-weight: 700;
}
.dp-subtotal { font-size: 0.86rem; font-weight: 700; color: var(--ink); white-space: nowrap; }

/* tfoot */
.dp-tfoot-row td {
    padding: 10px 14px;
    border-top: 1px solid var(--border);
    font-size: 0.80rem;
    color: var(--ink-2);
}
.dp-tfoot-label { font-weight: 500; }
.dp-tfoot-total td {
    padding: 13px 14px;
    background: linear-gradient(to right, var(--brand-ghost), var(--brand-pale));
    border-top: 2px solid var(--border-md);
}
.dp-tfoot-total-label { font-size: 0.86rem; font-weight: 700; color: var(--ink); }
.dp-tfoot-total-val {
    font-family: 'Cormorant Garamond', serif;
    font-size: 1.15rem;
    font-weight: 700;
    color: var(--brand-dk);
}

/* ── Summary card (sidebar) ── */
.dp-sum-lines { display: flex; flex-direction: column; gap: 9px; margin-bottom: 14px; padding-bottom: 14px; border-bottom: 1px dashed var(--border-md); }
.dp-sum-line { display: flex; justify-content: space-between; font-size: 0.80rem; color: var(--ink-2); }
.dp-sum-total {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 12px 14px;
    background: linear-gradient(135deg, var(--brand-ghost), var(--brand-pale));
    border: 1px solid var(--border);
    border-radius: var(--r-lg);
    font-size: 0.82rem;
    font-weight: 600;
    color: var(--ink-2);
}
.dp-sum-big {
    font-family: 'Cormorant Garamond', serif;
    font-size: 1.2rem;
    font-weight: 700;
    color: var(--brand-dk);
}

/* ── Form ── */
.dp-form-group { margin-bottom: 18px; }
.dp-label {
    display: flex;
    align-items: center;
    gap: 6px;
    font-size: 0.70rem;
    font-weight: 700;
    color: var(--ink-2);
    text-transform: uppercase;
    letter-spacing: 0.8px;
    margin-bottom: 7px;
}
.dp-label i { color: var(--brand); }
.dp-ctrl {
    width: 100%;
    padding: 10px 13px;
    background: var(--white);
    border: 1.5px solid var(--border-md);
    border-radius: var(--r-lg);
    font-size: 0.83rem;
    color: var(--ink);
    font-family: 'DM Sans', sans-serif;
    transition: border-color 0.18s, box-shadow 0.18s;
    resize: vertical;
    appearance: none;
    -webkit-appearance: none;
    outline: none;
}
.dp-ctrl:focus { border-color: var(--brand); box-shadow: 0 0 0 3px rgba(122,98,84,0.14); }
.dp-ctrl.is-invalid { border-color: var(--rose); }
.dp-select-wrap { position: relative; }
.dp-select-wrap .dp-ctrl { cursor: pointer; padding-right: 34px; }
.dp-select-ico { position: absolute; right: 11px; top: 50%; transform: translateY(-50%); color: var(--ink-4); font-size: 1.05rem; pointer-events: none; }
.dp-hint { display: flex; align-items: center; gap: 5px; font-size: 0.70rem; color: var(--ink-4); margin-top: 5px; }
.dp-error { font-size: 0.72rem; color: var(--rose); margin-top: 4px; }

.dp-resi-box {
    background: var(--surface-2);
    border: 1px solid var(--border);
    border-radius: var(--r-lg);
    padding: 11px 13px;
    margin-bottom: 18px;
}
.dp-resi-lbl { display: flex; align-items: center; gap: 5px; font-size: 0.66rem; font-weight: 700; color: var(--ink-4); text-transform: uppercase; letter-spacing: 0.8px; margin: 0 0 5px; }
.dp-resi-val { font-size: 0.82rem; font-weight: 600; color: var(--ink); margin: 0; font-family: 'Courier New', monospace; line-height: 1.6; }

.dp-form-actions { display: flex; flex-direction: column; gap: 9px; }
.dp-btn-save {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    width: 100%;
    padding: 11px 20px;
    background: linear-gradient(135deg, var(--brand) 0%, var(--brand-dk) 100%);
    color: #fff;
    border: none;
    border-radius: var(--r-lg);
    font-size: 0.85rem;
    font-weight: 700;
    font-family: 'DM Sans', sans-serif;
    cursor: pointer;
    transition: all 0.2s ease;
    box-shadow: var(--sh-brand);
    text-decoration: none;
}
.dp-btn-save:hover { transform: translateY(-2px); box-shadow: 0 8px 22px rgba(122,98,84,0.42); }

.dp-btn-cancel {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    width: 100%;
    padding: 10px 20px;
    background: var(--white);
    color: var(--ink-3);
    border: 1.5px solid var(--border-md);
    border-radius: var(--r-lg);
    font-size: 0.82rem;
    font-weight: 600;
    font-family: 'DM Sans', sans-serif;
    cursor: pointer;
    transition: all 0.18s ease;
    text-decoration: none;
}
.dp-btn-cancel:hover { background: var(--surface-2); color: var(--ink); }

/* ── Invoice card ── */
.dp-invoice-box {
    text-align: center;
    padding: 24px 20px;
}
.dp-invoice-ico {
    width: 52px; height: 52px;
    background: var(--brand-pale);
    border: 1px solid var(--border);
    border-radius: var(--r-xl);
    display: flex; align-items: center; justify-content: center;
    font-size: 1.5rem;
    color: var(--brand);
    margin: 0 auto 12px;
}
.dp-invoice-title { font-size: 0.88rem; font-weight: 700; color: var(--ink); margin: 0 0 4px; }
.dp-invoice-sub { font-size: 0.73rem; color: var(--ink-4); margin: 0 0 16px; }
.dp-btn-invoice {
    display: inline-flex;
    align-items: center;
    gap: 7px;
    padding: 9px 20px;
    background: var(--white);
    border: 1.5px solid var(--brand-lt);
    color: var(--brand-dk);
    border-radius: var(--r-lg);
    font-size: 0.80rem;
    font-weight: 700;
    text-decoration: none;
    transition: all 0.18s ease;
    font-family: 'DM Sans', sans-serif;
}
.dp-btn-invoice:hover { background: var(--brand-pale); transform: translateY(-1px); box-shadow: var(--sh-sm); color: var(--brand-dk); }
</style>

<!-- ══ PAGE BACK BUTTON ══ -->
<a href="{{ route('backend.pesanan.index') }}" class="dp-back">
    <i class="ri-arrow-left-s-line"></i> Kembali ke Daftar Pesanan
</a>

<!-- ══ HERO HEADER ══ -->
<div class="dp-hero">
    <div class="dp-hero-left">
        <div class="dp-id-badge">#{{ str_pad($order->id, 4, '0', STR_PAD_LEFT) }}</div>
        <div>
            <h1 class="dp-title">Detail Pesanan</h1>
            <p class="dp-date">
                <i class="ri-calendar-line"></i> {{ $order->created_at->format('d M Y') }}
                &nbsp;·&nbsp;
                <i class="ri-time-line"></i> {{ $order->created_at->format('H:i') }}
            </p>
        </div>
    </div>
    <div>
        <span class="dp-status
            @if($order->status == 'pending')  dp-s-pending
            @elseif($order->status == 'Paid') dp-s-paid
            @elseif($order->status == 'Kirim') dp-s-kirim
            @elseif($order->status == 'Selesai') dp-s-selesai
            @else dp-s-pending
            @endif">
            @if($order->status == 'pending')     <i class="ri-time-line"></i> Menunggu
            @elseif($order->status == 'Paid')    <i class="ri-checkbox-circle-line"></i> Dibayar
            @elseif($order->status == 'Kirim')   <i class="ri-truck-line"></i> Dikirim
            @elseif($order->status == 'Selesai') <i class="ri-medal-line"></i> Selesai
            @else                                <i class="ri-question-line"></i> {{ ucfirst($order->status) }}
            @endif
        </span>
    </div>
</div>

@if(session()->has('success'))
<div class="dp-alert" id="dpAlert">
    <i class="ri-checkbox-circle-fill"></i>
    <span>{{ session('success') }}</span>
    <button class="dp-alert-close" onclick="document.getElementById('dpAlert').remove()">
        <i class="ri-close-line"></i>
    </button>
</div>
@endif

<form action="{{ route('pesanan.update', $order->id) }}" method="POST">
    @csrf
    @method('PUT')

    <div class="dp-grid">

        <!-- ══════ LEFT COLUMN ══════ -->
        <div>

            <!-- Customer Info -->
            <div class="dp-card">
                <div class="dp-card-head">
                    <span class="dp-card-ico brand"><i class="ri-user-3-line"></i></span>
                    <h3 class="dp-card-title">Informasi Pelanggan</h3>
                </div>
                <div class="dp-card-body">
                    <div class="dp-customer-profile">
                        <div class="dp-avatar">
                            {{ strtoupper(substr($order->customer->user->nama ?? 'U', 0, 1)) }}
                        </div>
                        <div>
                            <p class="dp-cust-name">{{ $order->customer->user->nama ?? 'Tidak tersedia' }}</p>
                            <p class="dp-cust-email">{{ $order->customer->user->email ?? '-' }}</p>
                        </div>
                    </div>
                    <div class="dp-info-list">
                        <div class="dp-info-row">
                            <span class="dp-info-ico"><i class="ri-phone-line"></i></span>
                            <div>
                                <p class="dp-info-label">No. HP</p>
                                <p class="dp-info-val">{{ $order->hp ?? ($order->customer->user->hp ?? '-') }}</p>
                            </div>
                        </div>
                        <div class="dp-info-row">
                            <span class="dp-info-ico"><i class="ri-map-pin-line"></i></span>
                            <div>
                                <p class="dp-info-label">Alamat Pengiriman</p>
                                <p class="dp-info-val">{{ $order->alamat ?? '-' }}</p>
                                @if($order->pos)
                                    <p class="dp-info-sub">Kode Pos: {{ $order->pos }}</p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Products -->
            <div class="dp-card">
                <div class="dp-card-head">
                    <span class="dp-card-ico orange"><i class="ri-shopping-basket-line"></i></span>
                    <h3 class="dp-card-title">Daftar Produk</h3>
                    <span class="dp-card-badge">{{ $order->orderItems->count() }} item</span>
                </div>
                <div class="dp-card-body p-0">
                    <div class="dp-table-wrap">
                        <table class="dp-table">
                            <thead>
                                <tr>
                                    <th></th>
                                    <th>Produk</th>
                                    <th class="r">Harga</th>
                                    <th class="c">Qty</th>
                                    <th class="r">Subtotal</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($order->orderItems as $item)
                                    @php $subtotal = $item->harga * $item->quantity; @endphp
                                    <tr class="dp-prod-row">
                                        <td>
                                            @if($item->produk->foto)
                                                <img src="{{ asset('storage/img-produk/thumb_sm_' . $item->produk->foto) }}"
                                                     class="dp-thumb" alt="{{ $item->produk->nama_produk }}">
                                            @else
                                                <div class="dp-thumb-empty"><i class="ri-image-line"></i></div>
                                            @endif
                                        </td>
                                        <td>
                                            <p class="dp-prod-name">{{ $item->produk->nama_produk }}</p>
                                            <div class="dp-prod-tags">
                                                @if($item->size)
                                                    <span class="dp-tag dp-tag-size">{{ $item->size }}</span>
                                                @endif
                                                <span class="dp-tag dp-tag-cat">{{ $item->produk->kategori->nama_kategori ?? '-' }}</span>
                                            </div>
                                            <p class="dp-prod-meta">{{ $item->produk->berat }}g &nbsp;·&nbsp; Stok: {{ $item->produk->stok }}</p>
                                        </td>
                                        <td class="r">
                                            <span class="dp-price">Rp {{ number_format($item->harga, 0, ',', '.') }}</span>
                                        </td>
                                        <td class="c">
                                            <span class="dp-qty">{{ $item->quantity }}</span>
                                        </td>
                                        <td class="r">
                                            <span class="dp-subtotal">Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr class="dp-tfoot-row">
                                    <td colspan="4" class="r dp-tfoot-label">Subtotal</td>
                                    <td class="r">Rp {{ number_format($order->total_harga, 0, ',', '.') }}</td>
                                </tr>
                                @if($order->biaya_ongkir > 0)
                                    <tr class="dp-tfoot-row">
                                        <td colspan="4" class="r dp-tfoot-label">Biaya Ongkir</td>
                                        <td class="r">Rp {{ number_format($order->biaya_ongkir, 0, ',', '.') }}</td>
                                    </tr>
                                @endif
                                <tr class="dp-tfoot-total">
                                    <td colspan="4" class="r dp-tfoot-total-label">Total Bayar</td>
                                    <td class="r dp-tfoot-total-val">
                                        Rp {{ number_format($order->total_harga + $order->biaya_ongkir, 0, ',', '.') }}
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>

        </div>

        <!-- ══════ RIGHT COLUMN ══════ -->
        <div>

            <!-- Summary -->
            <div class="dp-card">
                <div class="dp-card-head">
                    <span class="dp-card-ico green"><i class="ri-bill-line"></i></span>
                    <h3 class="dp-card-title">Ringkasan Pembayaran</h3>
                </div>
                <div class="dp-card-body">
                    <div class="dp-sum-lines">
                        <div class="dp-sum-line">
                            <span>Subtotal Produk</span>
                            <span>Rp {{ number_format($order->total_harga, 0, ',', '.') }}</span>
                        </div>
                        @if($order->biaya_ongkir > 0)
                        <div class="dp-sum-line">
                            <span>Biaya Ongkir</span>
                            <span>Rp {{ number_format($order->biaya_ongkir, 0, ',', '.') }}</span>
                        </div>
                        @endif
                    </div>
                    <div class="dp-sum-total">
                        <span>Total Bayar</span>
                        <span class="dp-sum-big">Rp {{ number_format($order->total_harga + $order->biaya_ongkir, 0, ',', '.') }}</span>
                    </div>
                </div>
            </div>

            <!-- Update Pesanan -->
            <div class="dp-card">
                <div class="dp-card-head">
                    <span class="dp-card-ico blue"><i class="ri-edit-2-line"></i></span>
                    <h3 class="dp-card-title">Update Pesanan</h3>
                </div>
                <div class="dp-card-body">
                    <div class="dp-form-group">
                        <label class="dp-label" for="noresi">
                            <i class="ri-barcode-line"></i> No. Resi
                        </label>
                        <textarea id="noresi" name="noresi" rows="3"
                            class="dp-ctrl @error('noresi') is-invalid @enderror"
                            placeholder="Masukkan nomor resi...">{{ old('noresi', $order->noresi ?? 'NC-' . str_pad($order->id, 8, '0', STR_PAD_LEFT)) }}</textarea>
                        <p class="dp-hint"><i class="ri-information-line"></i> Baris baru untuk beberapa resi.</p>
                        @error('noresi')<p class="dp-error">{{ $message }}</p>@enderror
                    </div>

                    <div class="dp-form-group">
                        <label class="dp-label" for="status">
                            <i class="ri-loader-line"></i> Status Pesanan
                        </label>
                        <div class="dp-select-wrap">
                            <select id="status" name="status" class="dp-ctrl @error('status') is-invalid @enderror">
                                <option value="">— Pilih Status —</option>
                                <option value="Paid"    {{ old('status', $order->status) == 'Paid'    ? 'selected' : '' }}>✅ Diproses</option>
                                <option value="Kirim"   {{ old('status', $order->status) == 'Kirim'   ? 'selected' : '' }}>🚚 Dikirim</option>
                                <option value="Selesai" {{ old('status', $order->status) == 'Selesai' ? 'selected' : '' }}>🎉 Selesai</option>
                            </select>
                            <i class="ri-arrow-down-s-line dp-select-ico"></i>
                        </div>
                        @error('status')<p class="dp-error">{{ $message }}</p>@enderror
                    </div>

                    @if($order->noresi)
                    <div class="dp-resi-box">
                        <p class="dp-resi-lbl"><i class="ri-barcode-box-line"></i> Resi Tersimpan</p>
                        <p class="dp-resi-val">{!! nl2br(e($order->noresi)) !!}</p>
                    </div>
                    @endif

                    <div class="dp-form-actions">
                        <button type="submit" class="dp-btn-save">
                            <i class="ri-save-3-line"></i> Simpan Perubahan
                        </button>
                        <a href="{{ route('backend.pesanan.index') }}" class="dp-btn-cancel">
                            <i class="ri-close-line"></i> Batal
                        </a>
                    </div>
                </div>
            </div>

            <!-- Invoice -->
            <div class="dp-card">
                <div class="dp-card-head">
                    <span class="dp-card-ico purple"><i class="ri-file-text-line"></i></span>
                    <h3 class="dp-card-title">Invoice</h3>
                </div>
                <div class="dp-invoice-box">
                    <div class="dp-invoice-ico"><i class="ri-printer-line"></i></div>
                    <p class="dp-invoice-title">Cetak Invoice</p>
                    <p class="dp-invoice-sub">Unduh atau cetak invoice pesanan ini</p>
                    <a href="{{ route('pesanan.invoice', $order->id) }}" target="_blank" class="dp-btn-invoice">
                        <i class="ri-external-link-line"></i> Buka Invoice
                    </a>
                </div>
            </div>

        </div>

    </div>
</form>

@endsection
