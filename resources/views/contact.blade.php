<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hubungi Kami - Nyonya Crumb</title>
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,300;14..32,400;14..32,500;14..32,600;14..32,700&family=Playfair+Display:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        :root {
            --primary: #C47A3E;
            --primary-dark: #A05A2A;
            --primary-light: #FDE8D4;
            --bg-light: #FFF9F5;
            --bg-white: #FFFFFF;
            --text-dark: #1A1A1A;
            --text-muted: #6B6B6B;
            --border: #EFE5DC;
            --shadow: 0 4px 20px rgba(0,0,0,0.05);
            --radius: 16px;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: #f5f0ea;
            color: var(--text-dark);
            line-height: 1.5;
        }

        .container {
            max-width: 1100px;
            margin: 0 auto;
            padding: 0 20px;
        }

        /* ============ HEADER ============ */
        .main-header {
            background: var(--bg-white);
            position: sticky;
            top: 0;
            z-index: 1000;
            border-bottom: 1px solid var(--border);
        }

        .header-container {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 12px 24px;
            gap: 16px;
            flex-wrap: wrap;
            max-width: 1100px;
            margin: 0 auto;
        }

        .logo img {
            height: 42px;
        }

        .nav-links {
            display: flex;
            list-style: none;
            gap: 4px;
            flex-wrap: wrap;
        }

        .nav-links li a {
            display: inline-block;
            padding: 8px 14px;
            font-size: 14px;
            font-weight: 500;
            color: var(--text-dark);
            text-decoration: none;
            border-radius: 8px;
            transition: all 0.2s;
        }

        .nav-links li a:hover {
            color: var(--primary);
            background: var(--primary-light);
        }

        .nav-links li a.active {
            color: var(--primary);
            background: var(--primary-light);
        }

        .category-dropdown {
            position: relative;
        }

        .category-btn {
            background: var(--primary);
            color: white !important;
        }

        .category-btn:hover {
            background: var(--primary-dark);
            color: white !important;
        }

        .category-mega {
            position: absolute;
            top: 100%;
            left: 0;
            background: white;
            border-radius: 12px;
            box-shadow: var(--shadow);
            min-width: 200px;
            display: none;
            z-index: 100;
            padding: 8px 0;
            border: 1px solid var(--border);
        }

        .category-dropdown:hover .category-mega {
            display: block;
        }

        .category-mega a {
            display: block;
            padding: 10px 20px;
            font-size: 13px;
            color: var(--text-dark);
            text-decoration: none;
        }

        .category-mega a:hover {
            background: var(--primary-light);
            color: var(--primary);
        }

        .header-actions {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .action-btn {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 8px 16px;
            border-radius: 40px;
            text-decoration: none;
            color: var(--text-dark);
            font-weight: 500;
            font-size: 14px;
            transition: all 0.2s;
            position: relative;
        }

        .action-btn:hover {
            background: var(--primary-light);
            color: var(--primary);
        }

        .cart-badge {
            position: absolute;
            top: -6px;
            right: -8px;
            background: var(--primary);
            color: white;
            font-size: 10px;
            font-weight: 700;
            width: 18px;
            height: 18px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .dropdown {
            position: relative;
        }

        .dropdown-menu-custom {
            display: none;
            position: absolute;
            top: 100%;
            right: 0;
            background: white;
            border-radius: 12px;
            box-shadow: var(--shadow);
            min-width: 180px;
            z-index: 100;
            margin-top: 8px;
            border: 1px solid var(--border);
        }

        .dropdown:hover .dropdown-menu-custom {
            display: block;
        }

        .dropdown-menu-custom a {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 10px 16px;
            font-size: 13px;
            color: var(--text-dark);
            text-decoration: none;
            border-bottom: 1px solid var(--border);
        }

        .dropdown-menu-custom a:last-child {
            border-bottom: none;
        }

        .dropdown-menu-custom a:hover {
            background: var(--primary-light);
            color: var(--primary);
        }

        /* ============ CONTACT SECTION ============ */
        .contact-section {
            padding: 50px 0;
        }

        .contact-card {
            background: var(--bg-white);
            border-radius: var(--radius);
            box-shadow: var(--shadow);
            padding: 40px;
        }

        .back-btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 10px 20px;
            background: #f0f0f0;
            border-radius: 40px;
            text-decoration: none;
            color: var(--text-dark);
            font-size: 14px;
            font-weight: 500;
            margin-bottom: 24px;
            transition: all 0.2s;
        }

        .back-btn:hover {
            background: var(--primary-light);
            color: var(--primary);
        }

        .title-badge {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: var(--primary-light);
            padding: 6px 16px;
            border-radius: 40px;
            color: var(--primary);
            font-size: 13px;
            font-weight: 600;
            margin-bottom: 16px;
        }

        h1 {
            font-family: 'Playfair Display', serif;
            font-size: 32px;
            font-weight: 700;
            margin-bottom: 8px;
        }

        .subtitle {
            color: var(--text-muted);
            margin-bottom: 32px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            font-size: 14px;
            font-weight: 600;
            margin-bottom: 6px;
        }

        .form-group label i {
            color: var(--primary);
            margin-right: 6px;
        }

        .form-control {
            width: 100%;
            padding: 12px 16px;
            border: 1px solid var(--border);
            border-radius: 12px;
            font-family: 'Inter', sans-serif;
            font-size: 14px;
            transition: all 0.2s;
        }

        .form-control:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(196,122,62,0.1);
        }

        textarea.form-control {
            resize: vertical;
        }

        .btn-submit {
            background: var(--primary);
            color: white;
            padding: 12px 28px;
            border-radius: 40px;
            font-weight: 600;
            font-size: 14px;
            border: none;
            cursor: pointer;
            transition: all 0.2s;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .btn-submit:hover {
            background: var(--primary-dark);
            transform: translateY(-2px);
        }

        .alert-success {
            background: #d4edda;
            border: 1px solid #c3e6cb;
            color: #155724;
            padding: 14px 18px;
            border-radius: 12px;
            margin-bottom: 24px;
            font-size: 14px;
        }

        .alert-danger {
            background: #f8d7da;
            border: 1px solid #f5c6cb;
            color: #721c24;
            padding: 14px 18px;
            border-radius: 12px;
            margin-bottom: 24px;
            font-size: 14px;
        }

        .contact-info {
            margin-top: 32px;
            padding-top: 24px;
            border-top: 1px solid var(--border);
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 16px;
        }

        .info-item {
            display: flex;
            align-items: center;
            gap: 12px;
            font-size: 13px;
            color: var(--text-muted);
        }

        .info-item i {
            width: 32px;
            color: var(--primary);
            font-size: 16px;
        }

        .info-item a {
            color: var(--text-muted);
            text-decoration: none;
        }

        .info-item a:hover {
            color: var(--primary);
        }

        .footer-note {
            text-align: center;
            margin-top: 32px;
            font-size: 12px;
            color: var(--text-muted);
        }

        /* Responsive */
        @media (max-width: 768px) {
            .header-container {
                flex-direction: column;
                padding: 12px;
            }
            .nav-links {
                justify-content: center;
            }
            .contact-card {
                padding: 24px;
            }
            .contact-info {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 480px) {
            .nav-links li a {
                padding: 6px 10px;
                font-size: 12px;
            }
            .action-btn span {
                display: none;
            }
            .action-btn {
                padding: 8px 12px;
            }
            h1 {
                font-size: 26px;
            }
        }
    </style>
</head>
<body>

    <!-- HEADER -->
    <header class="main-header">
        <div class="header-container">
            <div class="logo">
                <a href="{{ url('/beranda') }}">
                    <img src="{{ asset('image/nyonyacrumb.jpeg') }}" alt="Nyonya Crumb">
                </a>
            </div>
            <ul class="nav-links">

                <li><a href="{{ route('beranda') }}">Beranda</a></li>
                <li><a href="{{ route('produk.all') }}">Produk</a></li>
                <li><a href="{{ route('cara.pesan') }}">Cara Pesan</a></li>

                <li><a href="{{ route('contact') }}" class="active">Kontak</a></li>
            </ul>

            <div class="header-actions">
                <a href="{{ route('v_order.cart') }}" class="action-btn">
                    <i class="fas fa-shopping-bag"></i>
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
                        <i class="fas fa-user-circle"></i>
                        <span>{{ Str::limit(Auth::user()->nama, 10) }}</span>
                    </div>
                    <div class="dropdown-menu-custom">
                        <a href="{{ route('customer.akun', ['id' => Auth::user()->id]) }}">
                            <i class="fas fa-user"></i> Profil Saya
                        </a>
                        <a href="{{ route('order.history') }}">
                            <i class="fas fa-history"></i> Riwayat Pesanan
                        </a>
                        <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" style="color: #C62828;">
                            <i class="fas fa-sign-out-alt"></i> Keluar
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">@csrf</form>
                    </div>
                </div>
                @else
                <a href="{{ route('auth.redirect') }}" class="action-btn">
                    <i class="fas fa-sign-in-alt"></i>
                    <span>Masuk</span>
                </a>
                @endif
            </div>
        </div>
    </header>

    <!-- CONTACT SECTION -->
    <section class="contact-section">
        <div class="container">
            <div class="contact-card">
                
                <div class="text-center">
                    <div class="title-badge">
                        <i class="fas fa-envelope"></i> Hubungi Kami
                    </div>
                    <h1>Contact Us</h1>
                    <p class="subtitle">Ada pertanyaan? Tim kami siap membantu Anda</p>
                </div>

                <!-- Flash Message Success -->
                @if(session('success'))
                    <div id="flash-success" class="alert-success">
                        <i class="fas fa-check-circle"></i> {{ session('success') }}
                    </div>
                @endif

                <!-- Flash Message Error -->
                @if(session('error'))
                    <div id="flash-error" class="alert-danger">
                        <i class="fas fa-exclamation-triangle"></i> {{ session('error') }}
                    </div>
                @endif

                <!-- Error Validation -->
                @if($errors->any())
                    <div class="alert-danger" style="margin-bottom: 20px;">
                        <ul style="margin-left: 20px; margin-bottom: 0;">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <!-- Form -->
                <form action="{{ route('contact.submit') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label><i class="fas fa-user"></i> Nama Lengkap <span style="color: red;">*</span></label>
                        <input type="text" name="name" class="form-control" placeholder="Masukkan nama Anda" value="{{ old('name') }}" required>
                    </div>

                    <div class="form-group">
                        <label><i class="fas fa-envelope"></i> Email <span style="color: red;">*</span></label>
                        <input type="email" name="email" class="form-control" placeholder="email@example.com" value="{{ old('email') }}" required>
                    </div>

                    <div class="form-group">
                        <label><i class="fas fa-tag"></i> Subjek</label>
                        <input type="text" name="subject" class="form-control" placeholder="Subjek pesan Anda" value="{{ old('subject') }}">
                    </div>

                    <div class="form-group">
                        <label><i class="fas fa-comment"></i> Pesan <span style="color: red;">*</span></label>
                        <textarea name="message" rows="4" class="form-control" placeholder="Tulis pesan Anda di sini..." required>{{ old('message') }}</textarea>
                    </div>

                    <div class="text-right">
                        <button type="submit" class="btn-submit">
                            <i class="fas fa-paper-plane"></i> Kirim Pesan
                        </button>
                    </div>
                </form>

            <div class="footer-note">
                <i class="fas fa-heart" style="color: #C47A3E;"></i> Kami akan membalas pesan Anda dalam 1x24 jam <i class="fas fa-heart" style="color: #C47A3E;"></i>
            </div>
        </div>
    </section>

    <script>
        // Auto hide flash message after 5 seconds
        setTimeout(function() {
            var success = document.getElementById('flash-success');
            var error = document.getElementById('flash-error');
            if (success) {
                success.style.opacity = '0';
                setTimeout(function() {
                    if(success.parentNode) success.remove();
                }, 500);
            }
            if (error) {
                error.style.opacity = '0';
                setTimeout(function() {
                    if(error.parentNode) error.remove();
                }, 500);
            }
        }, 5000);
    </script>
</body>
</html>