<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Nyonya Crumb - Cara Pemesanan</title>
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Playfair+Display:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- CSS Files -->
    <link rel="stylesheet" href="{{ asset('frontend/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/css/slick.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/css/slick-theme.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/css/nouislider.min.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/css/font-awesome.min.css') }}">

    
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: #FFF9F5;
            color: #1A1A1A;
        }

        h1, h2, h3 {
            font-family: 'Playfair Display', serif;
        }

        /* Warna utama */
        :root {
            --coklat: #C47A3E;
            --coklat-gelap: #A05A2A;
            --coklat-muda: #FDE8D4;
            --danger: #dc3545;
        }

        /* Container */
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }

        /* ===== HEADER ===== */
        .header {
            background: white;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
            position: sticky;
            top: 0;
            z-index: 100;
        }

        .header-inner {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px 20px;
            max-width: 1200px;
            margin: 0 auto;
            flex-wrap: wrap;
            gap: 15px;
        }

        .logo {
            font-size: 20px;
            font-weight: bold;
            background: var(--coklat);
            color: white;
            width: 45px;
            height: 45px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 12px;
            text-decoration: none;
        }

        .logo img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: 12px;
        }

        /* Navigasi */
        .nav-menu {
            display: flex;
            list-style: none;
            gap: 5px;
            flex-wrap: wrap;
            align-items: center;
        }

        .nav-menu a {
            text-decoration: none;
            padding: 8px 16px;
            color: #333;
            font-weight: 500;
            font-size: 14px;
            border-radius: 8px;
            transition: 0.2s;
        }

        .nav-menu a:hover {
            background: var(--coklat-muda);
            color: var(--coklat);
        }

        .nav-menu .active {
            color: var(--coklat);
            font-weight: 700;
        }

        /* Dropdown Kategori */
        .category-dropdown {
            position: relative;
        }

        .category-btn {
            background: transparent;
            cursor: pointer;
        }

        .category-mega {
            display: none;
            position: absolute;
            top: 100%;
            left: 0;
            background: white;
            min-width: 200px;
            box-shadow: 0 8px 16px rgba(0,0,0,0.1);
            border-radius: 8px;
            z-index: 1000;
            padding: 10px 0;
        }

        .category-dropdown:hover .category-mega {
            display: block;
        }

        .category-mega a {
            display: block;
            padding: 10px 20px;
            color: #333;
            text-decoration: none;
        }

        .category-mega a:hover {
            background: var(--coklat-muda);
            color: var(--coklat);
        }

        /* Header Actions */
        .header-actions {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .action-btn {
            display: flex;
            align-items: center;
            gap: 8px;
            text-decoration: none;
            padding: 8px 16px;
            background: white;
            border-radius: 40px;
            color: #333;
            font-weight: 500;
            position: relative;
            border: none;
            cursor: pointer;
            font-size: 14px;
        }

        .action-btn:hover {
            background: var(--coklat-muda);
        }

        .cart-badge {
            position: absolute;
            top: -5px;
            right: -5px;
            background: var(--coklat);
            color: white;
            border-radius: 50%;
            width: 18px;
            height: 18px;
            font-size: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        /* Dropdown user */
        .dropdown {
            position: relative;
        }

        .dropdown-menu-custom {
            display: none;
            position: absolute;
            top: 100%;
            right: 0;
            background: white;
            min-width: 180px;
            box-shadow: 0 8px 16px rgba(0,0,0,0.1);
            border-radius: 8px;
            z-index: 1000;
            padding: 10px 0;
        }

        .dropdown:hover .dropdown-menu-custom {
            display: block;
        }

        .dropdown-menu-custom a {
            display: block;
            padding: 10px 20px;
            color: #333;
            text-decoration: none;
            font-size: 14px;
        }

        .dropdown-menu-custom a:hover {
            background: var(--coklat-muda);
        }

        .d-none {
            display: none;
        }

        /* ===== HALAMAN CARA PESAN ===== */
        .page-title {
            text-align: center;
            padding: 60px 0 30px;
        }

        .page-title h1 {
            font-size: 42px;
            color: var(--coklat);
            margin-bottom: 15px;
        }

        .page-title p {
            color: #666;
            max-width: 600px;
            margin: 0 auto;
        }

        .garis {
            width: 80px;
            height: 3px;
            background: var(--coklat);
            margin: 20px auto;
            border-radius: 10px;
        }

        /* Step card */
        .steps-container {
            max-width: 900px;
            margin: 0 auto;
            background: white;
            border-radius: 24px;
            padding: 40px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.08);
            margin-bottom: 50px;
        }

        .step-item {
            display: flex;
            gap: 25px;
            margin-bottom: 45px;
            padding-bottom: 35px;
            border-bottom: 1px solid #EFE5DC;
        }

        .step-item:last-child {
            border-bottom: none;
            margin-bottom: 0;
            padding-bottom: 0;
        }

        .step-number {
            width: 60px;
            height: 60px;
            background: var(--coklat);
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 28px;
            font-weight: bold;
            font-family: 'Playfair Display', serif;
            flex-shrink: 0;
        }

        .step-icon {
            width: 60px;
            height: 60px;
            background: var(--coklat-muda);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .step-icon i {
            font-size: 28px;
            color: var(--coklat);
        }

        .step-content {
            flex: 1;
        }

        .step-content h3 {
            font-size: 22px;
            color: var(--coklat);
            margin-bottom: 10px;
        }

        .step-content p {
            color: #555;
            line-height: 1.6;
            margin-bottom: 10px;
        }

        .badge-list {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
            margin-top: 10px;
        }

        .badge {
            background: var(--coklat-muda);
            color: var(--coklat-gelap);
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 12px;
        }

        .info-box {
            background: var(--coklat-muda);
            border-radius: 16px;
            padding: 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 15px;
            margin-top: 30px;
        }

        .info-wa {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .info-wa i {
            font-size: 32px;
            color: #25D366;
        }

        .btn-back {
            background: white;
            border: 1px solid var(--coklat);
            padding: 10px 25px;
            border-radius: 40px;
            text-decoration: none;
            color: var(--coklat);
            font-weight: 600;
            transition: 0.2s;
            display: inline-block;
        }

        .btn-back:hover {
            background: var(--coklat);
            color: white;
        }

        /* Tips card */
        .tips-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 25px;
            margin: 50px 0;
            max-width: 700px;
            margin-left: auto;
            margin-right: auto;
        }

        .tip-card {
            background: white;
            padding: 25px;
            text-align: center;
            border-radius: 16px;
            border: 1px solid #EFE5DC;
            transition: 0.2s;
        }

        .tip-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 20px rgba(0,0,0,0.1);
        }

        .tip-card i {
            font-size: 40px;
            color: var(--coklat);
            margin-bottom: 15px;
        }

        .tip-card h4 {
            font-size: 18px;
            margin-bottom: 10px;
        }

        .tip-card p {
            font-size: 13px;
            color: #777;
        }

        /* Footer */
        .footer {
            background: white;
            padding: 50px 0 30px;
            margin-top: 50px;
            border-top: 1px solid #EFE5DC;
        }

        .footer-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 30px;
            margin-bottom: 30px;
        }

        .footer-col h5 {
            font-size: 12px;
            letter-spacing: 1px;
            color: #999;
            margin-bottom: 15px;
        }

        .footer-col ul {
            list-style: none;
        }

        .footer-col li {
            margin-bottom: 10px;
        }

        .footer-col a {
            text-decoration: none;
            color: #333;
            font-size: 14px;
            opacity: 0.7;
        }

        .footer-col a:hover {
            opacity: 1;
            color: var(--coklat);
        }

        .jam-list li {
            display: flex;
            gap: 10px;
            font-size: 13px;
            color: #666;
        }

        .jam-list i {
            color: var(--coklat);
            width: 16px;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .header-inner {
                flex-direction: column;
            }
            
            .steps-container {
                padding: 25px;
            }
            
            .step-item {
                flex-direction: column;
                align-items: center;
                text-align: center;
                gap: 15px;
            }
            
            .tips-grid {
                grid-template-columns: 1fr;
            }
            
            .footer-grid {
                grid-template-columns: repeat(2, 1fr);
            }
            
            .header-actions {
                flex-wrap: wrap;
                justify-content: center;
            }
        }
        
        @media (max-width: 480px) {
            .footer-grid {
                grid-template-columns: 1fr;
            }
            
            .page-title h1 {
                font-size: 32px;
            }
            
            .info-box {
                flex-direction: column;
                text-align: center;
            }
        }
    </style>
</head>
<body>

    <!-- HEADER -->
    <div class="header">
        <div class="header-inner">
            <a href="{{ route('beranda') }}" class="logo">
                <img src="{{ asset('image/nyonyacrumb.jpeg') }}" alt="Nyonya Crumb">
            </a>
            
            <ul class="nav-menu">
                <li><a href="{{ route('beranda') }}">Beranda</a></li>
                <li><a href="{{ route('produk.all') }}">Produk</a></li>
                <li><a href="{{ route('cara.pesan') }}" class="active">Cara Pesan</a></li>
                <li><a href="{{ route('contact') }}">Kontak</a></li>
            </ul>

            <div class="header-actions">
                <a href="{{ route('v_order.cart') }}" class="action-btn">
                    <i class="fa fa-shopping-bag"></i>
                    <span>Keranjang</span>
                    @php
                        $cartCount = 0;
                        if(Auth::check() && session('cart')) {
                            $cartCount = count(session('cart'));
                        }
                    @endphp
                    @if($cartCount > 0)
                        <span class="cart-badge">{{ $cartCount }}</span>
                    @endif
                </a>

                @if (Auth::check())
                <div class="dropdown">
                    <div class="action-btn">
                        <i class="fa fa-user-circle"></i>
                        <span>{{ Str::limit(Auth::user()->nama, 10) }}</span>
                    </div>
                    <div class="dropdown-menu-custom">
                        <a href="{{ route('customer.akun', ['id' => Auth::user()->id]) }}">
                            <i class="fa fa-user-o"></i> Profil Saya
                        </a>
                        <a href="{{ route('order.history') }}">
                            <i class="fa fa-history"></i> Riwayat Pesanan
                        </a>
                        <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" style="color: var(--danger);">
                            <i class="fa fa-sign-out"></i> Keluar
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">@csrf</form>
                    </div>
                </div>
                @else
                <a href="{{ route('auth.redirect') }}" class="action-btn">
                    <i class="fa fa-sign-in"></i>
                    <span>Masuk</span>
                </a>
                @endif
            </div>
        </div>
    </div>

    <!-- HALAMAN CARA PEMESANAN -->
    <div class="container">
        <div class="page-title">
            <h1>Cara <span style="color:#A05A2A">Pemesanan</span></h1>
            <div class="garis"></div>
            <p>Mudah, Cepat, dan Aman! Ikuti langkah-langkah berikut</p>
        </div>
        
        <div class="steps-container">
            <!-- STEP 1 -->
            <div class="step-item">
                <div class="step-icon">
                    <i class="fa fa-search"></i>
                </div>
                <div class="step-content">
                    <h3>1. Jelajahi Produk</h3>
                    <p>Kunjungi halaman <strong>Produk</strong> dan temukan berbagai varian kue kering homemade premium favorit Anda.</p>
                </div>
            </div>
            
            <!-- STEP 2 -->
            <div class="step-item">
                <div class="step-icon">
                    <i class="fa fa-mouse-pointer"></i>
                </div>
                <div class="step-content">
                    <h3>2. Pilih & Klik Pesan</h3>
                    <p>Klik produk yang Anda inginkan, lalu tekan tombol <strong>"Tambah ke Keranjang"</strong> untuk memasukkan kue pilihan Anda.</p>
                </div>
            </div>
            
            <!-- STEP 3 -->
            <div class="step-item">
                <div class="step-icon">
                    <i class="fa fa-shopping-cart"></i>
                </div>
                <div class="step-content">
                    <h3>3. Review Keranjang</h3>
                    <p>Klik ikon <strong>Keranjang</strong> di pojok kanan atas. Periksa kembali pesanan, jumlah, dan total harga Anda.</p>
                </div>
            </div>
            
            <!-- STEP 4 -->
            <div class="step-item">
                <div class="step-icon">
                    <i class="fa fa-credit-card"></i>
                </div>
                <div class="step-content">
                    <h3>4. Pilih Metode Pembayaran</h3>
                    <p>Lanjutkan ke checkout dan pilih metode pembayaran: <strong>Transfer Bank (BCA/Mandiri/BNI), E-Wallet (OVO/Dana/GoPay), atau COD</strong>.</p>
                </div>
            </div>
            
            <!-- STEP 5 -->
            <div class="step-item">
                <div class="step-icon">
                    <i class="fa fa-truck"></i>
                </div>
                <div class="step-content">
                    <h3>5. Pesanan Dikirim</h3>
                    <p>Setelah pembayaran dikonfirmasi, pesanan akan diproses dan dikirim ke alamat Anda dengan packing aman & higienis.</p>
                    <div class="badge-list">
                        <span class="badge"><i class="fa fa-clock-o"></i> Estimasi: 2-4 hari (Jabodetabek)</span>
                        <span class="badge">3-7 hari (Luar kota)</span>
                    </div>
                </div>
            </div>
            
            <!-- INFO BANTUAN -->
            <div class="info-box">
                <div class="info-wa">
                    <i class="fa fa-whatsapp"></i>
                    <div>
                        <strong>Butuh bantuan?</strong><br>
                        <small>Hubungi CS: +62 812-3456-7890 (WhatsApp)</small>
                    </div>
                </div>
                <a href="{{ route('beranda') }}" class="btn-back">← Kembali ke Beranda</a>
            </div>
        </div>
        
        <!-- TIPS CARD - Hanya 2 card, tanpa Hampers -->
        <div class="tips-grid">
            <div class="tip-card">
                <i class="fa fa-shield"></i>
                <h4>Garansi Kepuasan</h4>
                <p>Jika produk bermasalah, kami siap mengganti dengan produk baru</p>
            </div>
            <div class="tip-card">
                <i class="fa fa-leaf"></i>
                <h4>Homemade & Higienis</h4>
                <p>Diproduksi dengan standar kualitas premium</p>
            </div>
        </div>
    </div>

</body>
</html>