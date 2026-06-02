@extends('v_layouts.app')

@section('content')
<style>
    :root {
        --primary: #C47A3E;
        --primary-dark: #A05A2A;
        --primary-light: #FDE8D4;
        --bg-light: #FFF9F5;
        --bg-white: #FFFFFF;
        --text-dark: #1A1A1A;
        --text-muted: #6B6B6B;
        --border: #EFE5DC;
        --danger: #C62828;
        --shadow-sm: 0 4px 12px rgba(0,0,0,0.05);
        --shadow-md: 0 8px 24px rgba(0,0,0,0.08);
        --radius-sm: 8px;
        --radius-md: 16px;
        --radius-lg: 24px;
    }

    .cart-main-section {
        padding: 60px 0 80px;
        background: var(--bg-light);
        min-height: 70vh;
    }
    .cart-card {
        background: var(--bg-white);
        border-radius: var(--radius-lg);
        box-shadow: var(--shadow-sm);
        overflow: hidden;
        padding: 30px;
    }
    .section-title-cart {
        margin-bottom: 32px;
        border-bottom: 2px solid var(--border);
        padding-bottom: 16px;
    }
    .section-title-cart p {
        color: var(--primary);
        letter-spacing: 2px;
        font-size: 13px;
        font-weight: 600;
        margin-bottom: 8px;
    }
    .section-title-cart h3 {
        font-size: 28px;
        margin: 0;
        font-family: 'Playfair Display', serif;
    }
    .shopping-cart-table {
        width: 100%;
        margin-bottom: 40px;
    }
    .shopping-cart-table th {
        font-weight: 600;
        color: var(--text-dark);
        border-bottom: 1px solid var(--border);
        padding: 12px 8px;
    }
    .shopping-cart-table td {
        vertical-align: middle;
        padding: 20px 8px;
        border-bottom: 1px solid var(--border);
    }
    .cart-product-thumb img {
        width: 80px;
        height: 80px;
        object-fit: cover;
        border-radius: var(--radius-sm);
    }
    .cart-product-details a {
        font-weight: 700;
        color: var(--text-dark);
        text-decoration: none;
    }
    .cart-product-details ul {
        margin: 8px 0 0;
        padding: 0;
        list-style: none;
    }
    .cart-product-details li {
        font-size: 12px;
        color: var(--text-muted);
    }
    .qty-input {
        width: 70px;
        padding: 6px 8px;
        border-radius: var(--radius-sm);
        border: 1px solid var(--border);
        text-align: center;
    }
    .btn-update-qty {
        background: var(--bg-light);
        border: 1px solid var(--border);
        padding: 6px 12px;
        border-radius: var(--radius-sm);
        font-size: 12px;
        font-weight: 500;
        margin-left: 6px;
        transition: all 0.2s;
        cursor: pointer;
    }
    .btn-update-qty:hover {
        background: var(--primary);
        color: white;
        border-color: var(--primary);
    }
    .btn-remove {
        background: none;
        border: none;
        color: var(--danger);
        font-size: 18px;
        transition: transform 0.2s;
        cursor: pointer;
    }
    .btn-remove:hover { transform: scale(1.2); }

    .billing-details {
        background: var(--bg-light);
        padding: 24px;
        border-radius: var(--radius-md);
        height: 100%;
    }
    .billing-details h4 {
        font-family: 'Inter', sans-serif;
        margin-bottom: 20px;
        font-weight: 700;
    }
    .form-control-custom {
        width: 100%;
        padding: 10px 14px;
        border: 1px solid var(--border);
        border-radius: var(--radius-sm);
        margin-bottom: 16px;
        font-family: 'Inter', sans-serif;
        background: white;
        transition: border-color 0.2s;
    }
    .form-control-custom:focus {
        outline: none;
        border-color: var(--primary);
    }
    .btn-checkout {
        background: var(--primary);
        color: white;
        border: none;
        padding: 14px;
        font-weight: 700;
        border-radius: 40px;
        width: 100%;
        margin-top: 16px;
        transition: all 0.3s;
        cursor: pointer;
        font-size: 15px;
    }
    .btn-checkout:hover {
        background: var(--primary-dark);
        transform: translateY(-2px);
        box-shadow: var(--shadow-md);
    }
    .btn-checkout:disabled {
        background: #ccc;
        cursor: not-allowed;
        transform: none;
        box-shadow: none;
    }
    .alert-custom {
        padding: 16px 20px;
        border-radius: var(--radius-sm);
        margin-bottom: 24px;
    }
    .empty-cart-box {
        text-align: center;
        padding: 60px 20px;
    }
    .empty-cart-box i {
        font-size: 64px;
        color: #9E9E9E;
        margin-bottom: 20px;
    }
    .btn-primary-custom {
        background: var(--primary);
        color: white;
        padding: 12px 28px;
        border-radius: 50px;
        font-weight: 600;
        transition: all 0.3s;
        display: inline-block;
        text-decoration: none;
    }
    .btn-primary-custom:hover {
        background: var(--primary-dark);
        transform: translateY(-3px);
    }
    .size-badge-cart {
        display: inline-block;
        padding: 2px 10px;
        border-radius: 50px;
        font-size: 11px;
        font-weight: 700;
        letter-spacing: 0.5px;
        margin-top: 4px;
    }
    .size-badge-cart.big  { background: var(--primary-light); color: var(--primary-dark); }
    .size-badge-cart.small { background: #E3F2FD; color: #1565C0; }

    /* ===== SHIPPING SECTION ===== */
    .shipping-box {
        background: white;
        border: 1px solid var(--border);
        border-radius: var(--radius-sm);
        padding: 16px;
        margin-bottom: 16px;
    }
    .shipping-box label {
        font-size: 13px;
        font-weight: 600;
        color: var(--text-dark);
        display: block;
        margin-bottom: 6px;
    }

    .zona-badge {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 5px 14px;
        border-radius: 50px;
        font-size: 12px;
        font-weight: 600;
        margin-top: 4px;
        margin-bottom: 12px;
        transition: all 0.3s;
    }
    .zona-badge.zona-1 { background: #d4edda; color: #155724; }
    .zona-badge.zona-2 { background: #fff3cd; color: #856404; }
    .zona-badge.zona-3 { background: #fde8d4; color: #7d3c00; }
    .zona-badge.zona-4 { background: #f8d7da; color: #721c24; }
    .zona-badge.zona-unknown { background: #e2e3e5; color: #383d41; }
    .zona-badge.hidden { display: none; }

    .ekspedisi-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 10px;
        margin-top: 8px;
    }
    .ekspedisi-option {
        display: block;
    }
    .ekspedisi-label {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 12px 14px;
        border: 1.5px solid var(--border);
        border-radius: var(--radius-sm);
        cursor: pointer;
        transition: all 0.2s;
        background: white;
        user-select: none;
    }
    .ekspedisi-label:hover {
        border-color: var(--primary);
        background: var(--primary-light);
    }
    .ekspedisi-label input[type="radio"] {
        accent-color: var(--primary);
        width: 16px;
        height: 16px;
        flex-shrink: 0;
    }
    input[type="radio"]:checked + .ekspedisi-label,
    .ekspedisi-label:has(input[type="radio"]:checked) {
        border-color: var(--primary);
        background: var(--primary-light);
        box-shadow: 0 0 0 2px rgba(196,122,62,0.2);
    }
    .ekspedisi-info { flex: 1; }
    .ekspedisi-name {
        font-size: 13px;
        font-weight: 700;
        color: var(--text-dark);
        display: block;
    }
    .ekspedisi-est {
        font-size: 11px;
        color: var(--text-muted);
        display: block;
        margin-top: 1px;
    }
    .ekspedisi-price {
        font-size: 13px;
        font-weight: 700;
        color: var(--primary);
        white-space: nowrap;
    }

    .shipping-loading {
        display: none;
        text-align: center;
        padding: 16px;
        color: var(--text-muted);
        font-size: 13px;
        gap: 8px;
        align-items: center;
        justify-content: center;
    }
    .shipping-loading.show { display: flex; }
    .mini-spinner {
        width: 16px; height: 16px;
        border: 2px solid var(--primary-light);
        border-top-color: var(--primary);
        border-radius: 50%;
        animation: spin 0.8s linear infinite;
        flex-shrink: 0;
    }
    @keyframes spin { to { transform: rotate(360deg); } }

    .shipping-hint {
        text-align: center;
        padding: 14px;
        color: var(--text-muted);
        font-size: 13px;
        background: var(--bg-light);
        border-radius: var(--radius-sm);
        border: 1px dashed var(--border);
    }
    .shipping-hint i { margin-right: 6px; }

    .summary-table {
        width: 100%;
        background: white;
        border-radius: 12px;
        border-collapse: collapse;
    }
    .summary-table tr td {
        padding: 12px 4px;
        border-bottom: 1px solid var(--border);
    }
    .summary-table tr:last-child td { border-bottom: none; }

    @media (max-width: 768px) {
        .cart-card { padding: 20px; }
        .shopping-cart-table thead { display: none; }
        .shopping-cart-table tbody tr {
            display: block;
            margin-bottom: 30px;
            border: 1px solid var(--border);
            border-radius: var(--radius-md);
            padding: 16px;
        }
        .shopping-cart-table td {
            display: flex;
            justify-content: space-between;
            align-items: center;
            text-align: right;
            padding: 10px 0;
            border: none;
        }
        .shopping-cart-table td:before {
            content: attr(data-label);
            font-weight: 700;
            text-align: left;
            min-width: 100px;
        }
        .ekspedisi-grid { grid-template-columns: 1fr; }
    }
</style>

<div class="cart-main-section">
    <div class="container">
        <div class="cart-card">
            <div class="section-title-cart">
                <p>🛒 YOUR CART</p>
                <h3>Shopping Cart</h3>
            </div>

            @if(session()->has('success'))
            <div class="alert alert-success alert-custom" style="background:#d4edda;color:#155724; border:1px solid #c3e6cb;">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close" style="float:right;">&times;</button>
                <strong>{{ session('success') }}</strong>
            </div>
            @endif

            @if(session()->has('error'))
            <div class="alert alert-danger alert-custom" style="background:#f8d7da;color:#721c24; border:1px solid #f5c6cb;">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close" style="float:right;">&times;</button>
                <strong>{{ session('error') }}</strong>
            </div>
            @endif

            @if(isset($order) && $order && $order->orderItems->count() > 0)
            
            <!-- FORM UPDATE & REMOVE (dipisah dari checkout form) -->
            @foreach($order->orderItems as $item)
            <form action="{{ route('order.updateCart', $item->id) }}" method="POST" id="updateForm{{ $item->id }}" style="display:none;">
                @csrf
                <input type="number" name="quantity" id="updateQty{{ $item->id }}" value="{{ $item->quantity }}">
            </form>
            <form action="{{ route('order.remove', $item->id) }}" method="POST" id="removeForm{{ $item->id }}" style="display:none;">
                @csrf
            </form>
            @endforeach

            <!-- MAIN CHECKOUT FORM -->
            <form action="{{ route('order.checkout') }}" method="post" id="cartForm">
                @csrf
                <input type="hidden" name="biaya_ongkir" id="biaya_ongkir_hidden" value="0">
                <input type="hidden" name="ekspedisi" id="ekspedisi_hidden" value="">

                <table class="shopping-cart-table">
                    <thead>
                        <tr>
                            <th>Product</th>
                            <th></th>
                            <th class="text-center">Price</th>
                            <th class="text-center">Quantity</th>
                            <th class="text-center">Total</th>
                            <th class="text-right"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $totalHarga = 0; @endphp
                        @foreach($order->orderItems as $item)
                        @php $totalHarga += $item->harga * $item->quantity; @endphp
                        <tr>
                            <td class="cart-product-thumb" data-label="Product">
                                @php
                                    $fotoUrl = asset('frontend/images/default-product.jpg');
                                    if($item->produk && $item->produk->foto) {
                                        $fotoUrl = asset('storage/img-produk/' . $item->produk->foto);
                                    } elseif($item->produk && $item->produk->fotoProduk->first()) {
                                        $fotoUrl = asset('storage/img-produk/' . $item->produk->fotoProduk->first()->foto);
                                    }
                                @endphp
                                <img src="{{ $fotoUrl }}" alt="{{ $item->produk->nama_produk ?? 'Produk' }}">
                            </td>
                            <td class="cart-product-details" data-label="Details">
                                <a href="{{ route('produk.detail', $item->produk->id ?? '#') }}">{{ $item->produk->nama_produk ?? 'Produk' }}</a>
                                @if($item->size)
                                    <br>
                                    <span class="size-badge-cart {{ strtolower($item->size) }}">{{ $item->size }}</span>
                                @endif
                                <ul>
                                    <li><span>Berat: {{ $item->produk->berat ?? 0 }} Gram</span></li>
                                    <li><span>Stok: {{ $item->produk->stok ?? 0 }}</span></li>
                                </ul>
                            </td>
                            <td class="price text-center" data-label="Price">
                                <strong>Rp {{ number_format($item->harga, 0, ',', '.') }}</strong>
                            </td>
                            <td class="qty text-center" data-label="Quantity">
                                <input type="number" id="qty_{{$item->id}}" value="{{ $item->quantity }}" min="1" max="{{ $item->produk->stok ?? 99 }}" class="qty-input">
                                <button type="button" class="btn-update-qty" onclick="updateCartItem({{ $item->id }})">Update</button>
                            </td>
                            <td class="total text-center" data-label="Total">
                                <strong style="color: var(--primary);">Rp {{ number_format($item->harga * $item->quantity, 0, ',', '.') }}</strong>
                            </td>
                            <td class="text-right" data-label="">
                                <button type="button" class="btn-remove" onclick="removeCartItem({{ $item->id }})">
                                    <i class="fa fa-trash-o"></i>
                                </button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

                <div class="row" style="margin-top: 30px;">
                    <div class="col-md-6">
                        <div class="billing-details">
                            <h4>📦 Informasi Pengiriman</h4>

                            <div class="form-group">
                                <label>Alamat Lengkap *</label>
                                <input type="text" name="alamat" class="form-control-custom" required placeholder="Masukkan alamat lengkap">
                            </div>

                            <div class="form-group">
                                <label>Kode Pos *</label>
                                <div style="position:relative;">
                                    <input type="text" name="pos" id="kode_pos" class="form-control-custom" required
                                           placeholder="Contoh: 10110" maxlength="5"
                                           style="margin-bottom:4px; padding-right: 40px;"
                                           oninput="this.value = this.value.replace(/[^0-9]/g,'')">
                                    <i class="fa fa-map-marker" style="position:absolute;right:14px;top:12px;color:var(--primary);pointer-events:none;"></i>
                                </div>
                                <span id="zona-badge" class="zona-badge hidden"></span>
                            </div>

                            <div class="form-group">
                                <label>Nomor Telepon *</label>
                                <input type="text" name="hp" class="form-control-custom" required placeholder="Nomor HP aktif" maxlength="15">
                            </div>

                            <div class="shipping-box">
                                <label><i class="fa fa-truck" style="color:var(--primary); margin-right:6px;"></i> Pilih Ekspedisi & Layanan</label>
                                <div id="shipping-hint" class="shipping-hint">
                                    <i class="fa fa-info-circle"></i> Masukkan kode pos untuk melihat pilihan ekspedisi
                                </div>
                                <div id="shipping-loading" class="shipping-loading">
                                    <div class="mini-spinner"></div>
                                    Menghitung ongkos kirim...
                                </div>
                                <div id="ekspedisi-list" class="ekspedisi-grid"></div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="billing-details">
                            <h4>💰 Ringkasan Pesanan</h4>
                            <table class="summary-table">
                                <tr>
                                    <td><strong>SUBTOTAL</strong></td>
                                    <td style="text-align:right;"><strong id="subtotal_display">Rp {{ number_format($totalHarga, 0, ',', '.') }}</strong></td>
                                </tr>
                                <tr id="shipping-cost-row" style="display:none;">
                                    <td>
                                        <strong>BIAYA KIRIM</strong>
                                        <div id="ekspedisi-terpilih" style="font-size:11px; color:var(--text-muted); margin-top:2px;"></div>
                                    </td>
                                    <td style="text-align:right;">
                                        <strong id="ongkir-display" style="color:var(--text-muted);">—</strong>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="font-size:16px;"><strong>TOTAL PEMBAYARAN</strong></td>
                                    <td style="text-align:right;">
                                        <strong style="color:var(--primary); font-size:22px;" id="total_payment">
                                            Rp {{ number_format($totalHarga, 0, ',', '.') }}
                                        </strong>
                                    </td>
                                </tr>
                            </table>

                            <button type="submit" class="btn-checkout" id="pay-button" disabled>
                                ✅ LANJUTKAN PEMBAYARAN
                            </button>
                            <p id="checkout-hint" style="text-align:center; font-size:12px; color:var(--text-muted); margin-top:10px;">
                                Masukkan kode pos untuk melihat pilihan ekspedisi
                            </p>
                        </div>
                    </div>
                </div>
            </form>

            @else
            <div class="empty-cart-box">
                <i class="fa fa-shopping-basket"></i>
                <h3 style="margin: 20px 0 10px;">Keranjang Belanja Kosong</h3>
                <p style="color: #6B6B6B;">Yuk, isi dengan kue kering homemade favoritmu!</p>
                <a href="{{ route('produk.all') }}" class="btn-primary-custom" style="margin-top: 20px; display: inline-block;">Mulai Belanja →</a>
            </div>
            @endif
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function(){
    console.log("Document ready - Shipping script loaded");

    // Fungsi untuk Update Cart (langsung submit tanpa validasi form checkout)
    window.updateCartItem = function(itemId) {
        const newQty = $('#qty_' + itemId).val();
        $('#updateQty' + itemId).val(newQty);
        $('#updateForm' + itemId).submit();
    }

    // Fungsi untuk Remove Cart
    window.removeCartItem = function(itemId) {
        if(confirm('Yakin ingin menghapus item ini?')) {
            $('#removeForm' + itemId).submit();
        }
    }

    const shippingData = {
        '1': [
            { kurir: 'JNE', service: 'OKE', cost: 9000, etd: '2-3 hari' },
            { kurir: 'JNE', service: 'REG', cost: 12000, etd: '1-2 hari' },
            { kurir: 'JNE', service: 'YES', cost: 20000, etd: '1 hari' },
            { kurir: 'J&T', service: 'Reguler', cost: 10000, etd: '2-3 hari' },
            { kurir: 'J&T', service: 'Express', cost: 15000, etd: '1-2 hari' },
            { kurir: 'SiCepat', service: 'REG', cost: 11000, etd: '2-3 hari' },
            { kurir: 'SiCepat', service: 'BEST', cost: 18000, etd: '1 hari' },
            { kurir: 'AnterAja', service: 'Reguler', cost: 10000, etd: '2-4 hari' },
            { kurir: 'Pos Indonesia', service: 'POS Reguler', cost: 12000, etd: '3-5 hari' },
            { kurir: 'Lion Parcel', service: 'Reguler', cost: 13000, etd: '2-3 hari' }
        ],
        '2': [
            { kurir: 'JNE', service: 'OKE', cost: 16000, etd: '4-5 hari' },
            { kurir: 'JNE', service: 'REG', cost: 21000, etd: '2-3 hari' },
            { kurir: 'JNE', service: 'YES', cost: 35000, etd: '1-2 hari' },
            { kurir: 'J&T', service: 'Reguler', cost: 18000, etd: '3-4 hari' },
            { kurir: 'J&T', service: 'Express', cost: 25000, etd: '2-3 hari' },
            { kurir: 'SiCepat', service: 'REG', cost: 20000, etd: '3-4 hari' },
            { kurir: 'SiCepat', service: 'BEST', cost: 28000, etd: '2 hari' },
            { kurir: 'AnterAja', service: 'Reguler', cost: 19000, etd: '3-5 hari' },
            { kurir: 'Pos Indonesia', service: 'POS Reguler', cost: 18000, etd: '4-7 hari' },
            { kurir: 'Lion Parcel', service: 'Reguler', cost: 22000, etd: '3-4 hari' }
        ],
        '3': [
            { kurir: 'JNE', service: 'OKE', cost: 28000, etd: '5-7 hari' },
            { kurir: 'JNE', service: 'REG', cost: 35000, etd: '3-4 hari' },
            { kurir: 'JNE', service: 'YES', cost: 55000, etd: '2-3 hari' },
            { kurir: 'J&T', service: 'Reguler', cost: 30000, etd: '5-6 hari' },
            { kurir: 'J&T', service: 'Express', cost: 40000, etd: '3-4 hari' },
            { kurir: 'SiCepat', service: 'REG', cost: 32000, etd: '4-5 hari' },
            { kurir: 'SiCepat', service: 'BEST', cost: 45000, etd: '3 hari' },
            { kurir: 'AnterAja', service: 'Reguler', cost: 35000, etd: '5-7 hari' },
            { kurir: 'Pos Indonesia', service: 'POS Reguler', cost: 30000, etd: '7-10 hari' },
            { kurir: 'Lion Parcel', service: 'Reguler', cost: 38000, etd: '4-6 hari' }
        ],
        '4': [
            { kurir: 'JNE', service: 'OKE', cost: 45000, etd: '7-10 hari' },
            { kurir: 'JNE', service: 'REG', cost: 55000, etd: '5-6 hari' },
            { kurir: 'JNE', service: 'YES', cost: 85000, etd: '3-4 hari' },
            { kurir: 'J&T', service: 'Reguler', cost: 50000, etd: '7-8 hari' },
            { kurir: 'J&T', service: 'Express', cost: 65000, etd: '5-6 hari' },
            { kurir: 'SiCepat', service: 'REG', cost: 55000, etd: '6-7 hari' },
            { kurir: 'SiCepat', service: 'BEST', cost: 75000, etd: '4-5 hari' },
            { kurir: 'AnterAja', service: 'Reguler', cost: 60000, etd: '7-10 hari' },
            { kurir: 'Pos Indonesia', service: 'POS Reguler', cost: 50000, etd: '10-14 hari' },
            { kurir: 'Lion Parcel', service: 'Reguler', cost: 65000, etd: '6-8 hari' }
        ]
    };

    function getZonaFromPostalCode(postalCode) {
        if (!postalCode || postalCode.length < 2) return null;
        const prefix = postalCode.substring(0, 2);
        const zonaMap = {
            '10':1,'11':1,'12':1,'13':1,'14':1,'15':1,'16':1,'17':1,
            '18':2,'19':2,'20':2,'21':2,'22':2,'23':2,'24':2,'25':2,
            '26':2,'27':2,'28':2,'29':2,'30':2,'31':2,'32':2,'33':2,
            '34':2,'35':2,'36':2,'37':2,'38':2,'39':2,'40':2,'41':2,
            '42':2,'43':2,'44':2,'45':2,'46':2,'47':2,'48':2,'49':2,
            '50':2,'51':2,'52':2,'53':2,'54':2,'55':2,'56':2,'57':2,
            '58':2,'59':2,'60':2,'61':2,'62':2,'63':2,'64':2,'65':2,
            '66':2,'67':2,'68':2,'69':2,
            '70':3,'71':3,'72':3,'73':3,'74':3,'75':3,'76':3,'77':3,
            '78':3,'79':3,'80':3,'81':3,'82':3,'83':3,'84':3,'85':3,
            '86':4,'87':4,'88':4,'89':4,'90':4,'91':4,'92':4,'93':4,
            '94':4,'95':4,'96':4,'97':4,'98':4,'99':4
        };
        return zonaMap[prefix] || null;
    }

    const subtotal = {{ $totalHarga ?? 0 }};
    let selectedShippingCost = 0;
    let selectedShippingName = '';

    function formatRupiah(angka) {
        return 'Rp ' + angka.toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.');
    }

    function updateTotal() {
        const total = subtotal + selectedShippingCost;
        $('#total_payment').text(formatRupiah(total));
    }

    function displayShippingOptions(zona) {
        const options = shippingData[zona.toString()];
        
        if (!options || options.length === 0) {
            $('#shipping-hint').show().html('<i class="fa fa-exclamation-triangle" style="color:#C62828;"></i> Tidak ada pilihan ekspedisi untuk zona ini.');
            $('#ekspedisi-list').empty();
            return;
        }

        let html = '';
        options.forEach((opt, index) => {
            const uniqueId = `kurir_${zona}_${index}`;
            html += `
                <div class="ekspedisi-option">
                    <label class="ekspedisi-label" for="${uniqueId}">
                        <input type="radio" name="pilih_ekspedisi" id="${uniqueId}"
                               value="${opt.cost}" data-cost="${opt.cost}"
                               data-name="${opt.kurir} ${opt.service}">
                        <div class="ekspedisi-info">
                            <span class="ekspedisi-name">${opt.kurir} <small style="font-weight:400;">${opt.service}</small></span>
                            <span class="ekspedisi-est"><i class="fa fa-clock-o"></i> ${opt.etd}</span>
                        </div>
                        <span class="ekspedisi-price">${formatRupiah(opt.cost)}</span>
                    </label>
                </div>
            `;
        });

        $('#ekspedisi-list').html(html);
        $('#ekspedisi-list').show();
        $('#shipping-hint').hide();

        $('input[name="pilih_ekspedisi"]').on('change', function() {
            selectedShippingCost = parseInt($(this).data('cost'));
            selectedShippingName = $(this).data('name');
            
            updateTotal();
            $('#biaya_ongkir_hidden').val(selectedShippingCost);
            $('#ekspedisi_hidden').val(selectedShippingName);
            $('#ekspedisi-terpilih').text(selectedShippingName);
            $('#ongkir-display').text(formatRupiah(selectedShippingCost)).css('color', 'var(--text-dark)');
            $('#shipping-cost-row').show();
            $('#pay-button').prop('disabled', false);
            $('#checkout-hint').hide();
        });
    }

    $('#kode_pos').on('input', function() {
        const kodePos = $(this).val().trim();
        
        selectedShippingCost = 0;
        selectedShippingName = '';
        $('#biaya_ongkir_hidden').val('');
        $('#ekspedisi_hidden').val('');
        $('#pay-button').prop('disabled', true);
        $('#shipping-cost-row').hide();
        $('#ongkir-display').text('—');
        $('#ekspedisi-terpilih').text('');
        updateTotal();
        
        if (kodePos.length < 5) {
            $('#shipping-hint').show().html('<i class="fa fa-info-circle"></i> Masukkan kode pos (5 digit) untuk melihat pilihan ekspedisi');
            $('#ekspedisi-list').empty().hide();
            $('#zona-badge').addClass('hidden');
            $('#checkout-hint').show().text('Masukkan kode pos untuk melihat pilihan ekspedisi');
            return;
        }
        
        $('#shipping-hint').hide();
        $('#shipping-loading').addClass('show');
        $('#ekspedisi-list').empty().hide();
        
        setTimeout(() => {
            $('#shipping-loading').removeClass('show');
            
            const zona = getZonaFromPostalCode(kodePos);
            
            if (!zona) {
                $('#shipping-hint').show().html('<i class="fa fa-exclamation-triangle" style="color:#C62828;"></i> Kode pos tidak dikenali.');
                $('#zona-badge').removeClass('hidden').addClass('zona-unknown').html('⚠️ Zona tidak dikenal');
                $('#checkout-hint').show().text('Kode pos tidak valid');
                return;
            }
            
            const zonaNames = {
                1: { label: 'Zona 1 - Jabodetabek', class: 'zona-1', icon: '📍' },
                2: { label: 'Zona 2 - Jawa', class: 'zona-2', icon: '🗺️' },
                3: { label: 'Zona 3 - Sumatera/Bali/Kalimantan', class: 'zona-3', icon: '✈️' },
                4: { label: 'Zona 4 - Sulawesi/Papua/Maluku', class: 'zona-4', icon: '🌏' }
            };
            
            const zInfo = zonaNames[zona];
            $('#zona-badge')
                .removeClass('hidden')
                .removeClass('zona-1 zona-2 zona-3 zona-4 zona-unknown')
                .addClass(zInfo.class)
                .html(`${zInfo.icon} ${zInfo.label}`);
            
            displayShippingOptions(zona);
            $('#checkout-hint').show().text('Silakan pilih ekspedisi');
            
        }, 800);
    });

    setTimeout(function() { 
        $('.alert').fadeOut('slow'); 
    }, 3000);
});
</script>
@endsection