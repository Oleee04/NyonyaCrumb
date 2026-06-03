@extends('v_layouts.app')

@section('content')
<style>
    .cart-main-section {
        padding: 160px 0 100px;
        min-height: 80vh;
        background: var(--bg-creme);
    }

    .cart-card {
        background: var(--bg-white);
        border: 1px solid var(--border);
        padding: 40px;
        position: relative;
    }

    .section-title-cart {
        text-align: center;
        margin-bottom: 50px;
    }

    .section-title-cart h3 {
        font-family: 'Cormorant Garamond', serif;
        font-size: 42px;
        font-weight: 600;
        color: var(--text-dark);
        margin-bottom: 10px;
    }

    .section-title-cart p {
        color: var(--text-muted);
        font-size: 14px;
        letter-spacing: 2px;
        text-transform: uppercase;
    }

    .shopping-cart-table {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 50px;
    }

    .shopping-cart-table th {
        text-align: left;
        font-size: 11px;
        text-transform: uppercase;
        letter-spacing: 1px;
        color: var(--text-muted);
        padding: 15px 10px;
        border-bottom: 1px solid var(--border);
        font-weight: 600;
    }

    .shopping-cart-table td {
        padding: 25px 10px;
        border-bottom: 1px solid var(--border-light);
        vertical-align: middle;
    }

    .cart-product-thumb img {
        width: 80px;
        height: 80px;
        object-fit: cover;
        background: var(--bg-creme);
        border: 1px solid var(--border);
    }

    .cart-product-details a {
        font-family: 'DM Sans', sans-serif;
        font-size: 16px;
        font-weight: 600;
        color: var(--text-dark);
        text-decoration: none;
    }

    .size-badge-nc {
        display: inline-block;
        font-size: 10px;
        padding: 2px 8px;
        background: var(--bg-creme);
        color: var(--primary);
        letter-spacing: 1px;
        text-transform: uppercase;
        font-weight: 600;
        margin-top: 5px;
    }

    .qty-input {
        width: 60px;
        padding: 8px;
        border: 1px solid var(--border);
        text-align: center;
        font-size: 14px;
        font-family: 'DM Sans', sans-serif;
    }

    .btn-update-qty {
        background: transparent;
        border: 1px solid var(--border);
        padding: 8px 12px;
        font-size: 10px;
        text-transform: uppercase;
        letter-spacing: 1px;
        font-weight: 600;
        cursor: pointer;
        transition: 0.3s;
        margin-left: 5px;
    }

    .btn-update-qty:hover {
        background: var(--text-dark);
        color: white;
    }

    .btn-remove {
        background: none;
        border: none;
        color: #E53935;
        cursor: pointer;
        font-size: 16px;
        transition: 0.3s;
    }

    .btn-remove:hover {
        transform: scale(1.1);
    }

    .billing-details {
        padding: 30px;
        border: 1px solid var(--border);
        background: var(--bg-creme);
        height: 100%;
    }

    .billing-details h4 {
        font-family: 'Cormorant Garamond', serif;
        font-size: 24px;
        font-weight: 600;
        margin-bottom: 25px;
        border-bottom: 1px solid var(--border);
        padding-bottom: 10px;
    }

    .form-control-custom {
        width: 100%;
        padding: 12px;
        border: 1px solid var(--border);
        background: white;
        font-family: 'DM Sans', sans-serif;
        font-size: 14px;
        margin-bottom: 20px;
    }

    .btn-checkout-nc {
        width: 100%;
        padding: 16px;
        background: var(--text-dark);
        color: white;
        border: none;
        font-size: 11px;
        letter-spacing: 2px;
        text-transform: uppercase;
        font-weight: 600;
        cursor: pointer;
        transition: 0.3s;
        margin-top: 20px;
    }

    .btn-checkout-nc:hover:not(:disabled) {
        background: var(--primary);
    }

    .btn-checkout-nc:disabled {
        opacity: 0.5;
        cursor: not-allowed;
    }

    .zona-badge {
        display: inline-block;
        font-size: 11px;
        padding: 4px 12px;
        background: #E8F5E9;
        color: #2E7D32;
        font-weight: 600;
        margin-bottom: 15px;
    }

    .ekspedisi-label {
        display: flex;
        align-items: center;
        padding: 15px;
        border: 1px solid var(--border);
        background: white;
        cursor: pointer;
        transition: 0.3s;
        margin-bottom: 10px;
    }

    .ekspedisi-label:hover {
        border-color: var(--primary);
    }

    .ekspedisi-name {
        font-size: 13px;
        font-weight: 600;
        display: block;
    }

    .ekspedisi-est {
        font-size: 11px;
        color: var(--text-muted);
    }

    .summary-table {
        width: 100%;
        margin-top: 20px;
    }

    .summary-table td {
        padding: 10px 0;
        font-size: 14px;
    }

    .total-row {
        border-top: 1px solid var(--border);
        padding-top: 20px;
        margin-top: 20px;
    }

    @media (max-width: 768px) {
        .cart-main-section { padding: 180px 0 60px; }
        .cart-card { padding: 20px; }
        .shopping-cart-table thead { display: none; }
        .shopping-cart-table tr { display: block; margin-bottom: 25px; border-bottom: 2px solid var(--border); }
        .shopping-cart-table td { display: block; text-align: right; padding: 10px 0; border: none; }
        .shopping-cart-table td:before { content: attr(data-label); float: left; font-weight: 600; text-transform: uppercase; font-size: 11px; }
    }
</style>

<div class="cart-main-section">
    <div class="container">
        <div class="cart-card">
            <div class="section-title-cart reveal">
                <p>Pesanan Anda</p>
                <h3>Keranjang <i>Belanja</i></h3>
            </div>

            @if(session()->has('success'))
            <div class="alert alert-success alert-custom reveal" style="border-radius:0; border:none; background:#E8F5E9; color:#2E7D32;">
                {{ session('success') }}
            </div>
            @endif

            @if(session()->has('error'))
            <div class="alert alert-danger alert-custom reveal" style="border-radius:0; border:none; background:#FFEBEE; color:#C62828;">
                {{ session('error') }}
            </div>
            @endif

            @if(isset($order) && $order && $order->orderItems->count() > 0)
            
            @foreach($order->orderItems as $item)
            <form action="{{ route('order.updateCart', $item->id) }}" method="POST" id="updateForm{{ $item->id }}" style="display:none;">
                @csrf
                <input type="number" name="quantity" id="updateQty{{ $item->id }}" value="{{ $item->quantity }}">
            </form>
            <form action="{{ route('order.remove', $item->id) }}" method="POST" id="removeForm{{ $item->id }}" style="display:none;">
                @csrf
            </form>
            @endforeach

            <form action="{{ route('order.checkout') }}" method="post" id="cartForm">
                @csrf
                <input type="hidden" name="biaya_ongkir" id="biaya_ongkir_hidden" value="0">
                <input type="hidden" name="ekspedisi" id="ekspedisi_hidden" value="">

                <div class="table-responsive reveal">
                    <table class="shopping-cart-table">
                        <thead>
                            <tr>
                                <th>Produk</th>
                                <th></th>
                                <th>Harga</th>
                                <th>Jumlah</th>
                                <th>Total</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $totalHarga = 0; @endphp
                            @foreach($order->orderItems as $item)
                            @php $totalHarga += $item->harga * $item->quantity; @endphp
                            <tr>
                                <td class="cart-product-thumb" data-label="Produk">
                                    <img src="{{ asset('storage/img-produk/' . ($item->produk->foto ?? 'default.jpg')) }}" alt="{{ $item->produk->nama_produk ?? 'Produk' }}">
                                </td>
                                <td class="cart-product-details">
                                    <a href="{{ route('produk.detail', $item->produk->id ?? '#') }}">{{ $item->produk->nama_produk ?? 'Produk' }}</a>
                                    @if($item->size)
                                        <br><span class="size-badge-nc">Ukuran: {{ $item->size }}</span>
                                    @endif
                                </td>
                                <td data-label="Harga">
                                    Rp {{ number_format($item->harga, 0, ',', '.') }}
                                </td>
                                <td data-label="Jumlah">
                                    <input type="number" id="qty_{{$item->id}}" value="{{ $item->quantity }}" min="1" max="{{ $item->produk->stok ?? 99 }}" class="qty-input">
                                    <button type="button" class="btn-update-qty" onclick="updateCartItem({{ $item->id }})">Update</button>
                                </td>
                                <td data-label="Total" style="font-weight: 600; color: var(--primary);">
                                    Rp {{ number_format($item->harga * $item->quantity, 0, ',', '.') }}
                                </td>
                                <td class="text-right">
                                    <button type="button" class="btn-remove" onclick="removeCartItem({{ $item->id }})">
                                        <i class="fa fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="row reveal">
                    <div class="col-md-7">
                        <div class="billing-details">
                            <h4>📦 Informasi Pengiriman</h4>

                            <div class="form-group">
                                <label style="font-size:12px; text-transform:uppercase; letter-spacing:1px; font-weight:600; margin-bottom:10px; display:block;">Alamat Lengkap</label>
                                <input type="text" name="alamat" class="form-control-custom" required placeholder="Masukkan alamat lengkap">
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label style="font-size:12px; text-transform:uppercase; letter-spacing:1px; font-weight:600; margin-bottom:10px; display:block;">Kode Pos</label>
                                        <input type="text" name="pos" id="kode_pos" class="form-control-custom" required placeholder="5 Digit Kode Pos" maxlength="5">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label style="font-size:12px; text-transform:uppercase; letter-spacing:1px; font-weight:600; margin-bottom:10px; display:block;">Nomor Telepon</label>
                                        <input type="text" name="hp" class="form-control-custom" required placeholder="Contoh: 0812..." maxlength="15">
                                    </div>
                                </div>
                            </div>

                            <div id="zona-badge" class="zona-badge hidden"></div>

                            <div style="margin-top:20px;">
                                <label style="font-size:12px; text-transform:uppercase; letter-spacing:1px; font-weight:600; margin-bottom:15px; display:block;">Pilih Ekspedisi</label>
                                <div id="shipping-hint" style="font-size:13px; color:var(--text-muted); border:1px dashed var(--border); padding:15px; text-align:center;">
                                    Masukkan kode pos untuk melihat pilihan ekspedisi
                                </div>
                                <div id="shipping-loading" class="shipping-loading" style="display:none; text-align:center; padding:15px;">
                                    <div class="mini-spinner"></div> Sedang menghitung...
                                </div>
                                <div id="ekspedisi-list"></div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-5">
                        <div class="billing-details">
                            <h4>💰 Ringkasan Belanja</h4>
                            <table class="summary-table">
                                <tr>
                                    <td>Total Produk</td>
                                    <td class="text-right">Rp {{ number_format($totalHarga, 0, ',', '.') }}</td>
                                </tr>
                                <tr id="shipping-cost-row" style="display:none;">
                                    <td>
                                        Ongkos Kirim
                                        <div id="ekspedisi-terpilih" style="font-size:11px; color:var(--text-muted);"></div>
                                    </td>
                                    <td class="text-right" id="ongkir-display">—</td>
                                </tr>
                                <tr class="total-row">
                                    <td style="font-weight: 600; font-size: 16px;">Total Bayar</td>
                                    <td class="text-right" style="font-weight: 600; font-size: 20px; color: var(--primary);" id="total_payment">
                                        Rp {{ number_format($totalHarga, 0, ',', '.') }}
                                    </td>
                                </tr>
                            </table>

                            <button type="submit" class="btn-checkout-nc" id="pay-button" disabled>
                                Lanjutkan Pembayaran
                            </button>
                            <p id="checkout-hint" style="text-align:center; font-size:11px; color:var(--text-muted); margin-top:15px;">
                                Lengkapi alamat & pilih ekspedisi untuk membayar
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
            { kurir: 'GoSend', service: 'Instant', cost: 25000, etd: 'Hari ini (2-3 Jam)' },
            { kurir: 'GrabExpress', service: 'Instant', cost: 26000, etd: 'Hari ini (2-3 Jam)' },
            { kurir: 'Paxel', service: 'Next Day', cost: 20000, etd: '1 hari' },
            { kurir: 'JNE', service: 'YES', cost: 20000, etd: '1 hari' },
            { kurir: 'SiCepat', service: 'BEST', cost: 18000, etd: '1 hari' }
        ],
        '2': [
            { kurir: 'Paxel', service: 'Next Day', cost: 35000, etd: '1 hari' },
            { kurir: 'JNE', service: 'YES', cost: 35000, etd: '1-2 hari' },
            { kurir: 'SiCepat', service: 'BEST', cost: 28000, etd: '1-2 hari' }
        ],
        '3': [
            { kurir: 'JNE', service: 'YES', cost: 55000, etd: '1-2 hari' },
            { kurir: 'SiCepat', service: 'BEST', cost: 45000, etd: '1-2 hari' }
        ],
        '4': [
            { kurir: 'JNE', service: 'YES', cost: 85000, etd: '1-2 hari' },
            { kurir: 'SiCepat', service: 'BEST', cost: 75000, etd: '1-2 hari' }
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