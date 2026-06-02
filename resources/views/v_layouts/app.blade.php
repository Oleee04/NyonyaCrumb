<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('image/icon_univ_bsi.png') }}">
    <title> Nyonya Crumb - Kue Kering Homemade Premium</title>

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,300;14..32,400;14..32,500;14..32,600;14..32,700;14..32,800&family=Playfair+Display:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- CSS Files -->
    <link rel="stylesheet" href="{{ asset('frontend/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/css/slick.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/css/slick-theme.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/css/nouislider.min.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/css/font-awesome.min.css') }}">

    <style>
        *, *::before, *::after { margin: 0; padding: 0; box-sizing: border-box; }

        :root {
            --primary: #C47A3E;
            --primary-dark: #A05A2A;
            --primary-light: #FDE8D4;
            --secondary: #2C2C2C;
            --accent: #E8B87A;
            --bg-light: #FFF9F5;
            --bg-white: #FFFFFF;
            --text-dark: #1A1A1A;
            --text-muted: #6B6B6B;
            --text-light: #9E9E9E;
            --border: #EFE5DC;
            --success: #2E7D32;
            --danger: #C62828;
            --shadow-sm: 0 4px 12px rgba(0,0,0,0.05);
            --shadow-md: 0 8px 24px rgba(0,0,0,0.08);
            --shadow-lg: 0 16px 40px rgba(0,0,0,0.12);
            --radius-sm: 8px;
            --radius-md: 16px;
            --radius-lg: 24px;
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--bg-light);
            color: var(--text-dark);
            line-height: 1.5;
            overflow-x: hidden;
        }

        h1, h2, h3, h4, h5, h6 { font-family: 'Playfair Display', serif; font-weight: 700; }

        .container { max-width: 1280px; margin: 0 auto; padding: 0 24px; }

        /* ============ ANIMATIONS ============ */
        @keyframes fadeInUp { from { opacity: 0; transform: translateY(30px); } to { opacity: 1; transform: translateY(0); } }
        @keyframes slideInLeft { from { transform: translateX(-100%); opacity: 0; } to { transform: translateX(0); opacity: 1; } }
        @keyframes bounceIn { 0% { opacity: 0; transform: scale(0.3); } 50% { opacity: 1; transform: scale(1.05); } 70% { transform: scale(0.9); } 100% { transform: scale(1); } }
        @keyframes float { 0%, 100% { transform: translateY(0px); } 50% { transform: translateY(-10px); } }
        @keyframes pulse { 0%, 100% { transform: scale(1); } 50% { transform: scale(1.05); } }
        @keyframes zoomIn { from { opacity: 0; transform: scale(0.5); } to { opacity: 1; transform: scale(1); } }
        @keyframes heartbeat { 0%, 100% { transform: scale(1); } 50% { transform: scale(1.2); } }
        @keyframes spin { to { transform: rotate(360deg); } }

        .animate-fadeInUp { animation: fadeInUp 0.8s ease forwards; }
        .animate-zoomIn { animation: zoomIn 1s ease forwards; }
        .pulse-animation { animation: pulse 2s ease-in-out infinite; }

        .stagger-child > * { opacity: 0; }
        .stagger-child > *:nth-child(1) { animation: fadeInUp 0.6s ease forwards 0.1s; }
        .stagger-child > *:nth-child(2) { animation: fadeInUp 0.6s ease forwards 0.2s; }
        .stagger-child > *:nth-child(3) { animation: fadeInUp 0.6s ease forwards 0.3s; }

        .reveal { opacity: 0; transform: translateY(30px); transition: all 0.8s ease; }
        .reveal.active { opacity: 1; transform: translateY(0); }

        /* ============ HEADER ============ */
        .main-header {
            background: var(--bg-white);
            position: sticky; top: 0; z-index: 1000;
            box-shadow: var(--shadow-sm);
            border-bottom: 1px solid var(--border);
        }

        .header-container {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 12px 32px;
            gap: 24px;
            max-width: 1400px;
            margin: 0 auto;
        }

        .logo { flex-shrink: 0; }
        .logo img { height: 45px; transition: transform 0.3s; display: block; }
        .logo img:hover { transform: scale(1.05); }

        /* Navigation - Centered */
        .nav-links {
            display: flex;
            list-style: none;
            gap: 8px;
            margin: 0;
            padding: 0;
            flex: 1;
            justify-content: center;
        }

        .nav-links li a {
            display: inline-block;
            padding: 10px 20px;
            font-size: 15px;
            font-weight: 500;
            color: var(--text-dark);
            transition: all 0.2s;
            border-radius: var(--radius-sm);
            text-decoration: none;
            position: relative;
        }

        .nav-links li a::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 50%;
            width: 0;
            height: 2px;
            background: var(--primary);
            transition: all 0.3s;
            transform: translateX(-50%);
        }

        .nav-links li a:hover::after {
            width: 30px;
        }

        .nav-links li a:hover {
            color: var(--primary);
            background: var(--bg-light);
        }

        /* Header Actions - Right aligned */
        .header-actions {
            display: flex;
            align-items: center;
            gap: 12px;
            flex-shrink: 0;
        }

        .action-btn {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 8px 18px;
            border-radius: 40px;
            cursor: pointer;
            transition: all 0.2s;
            background: none;
            border: none;
            font-family: 'Inter', sans-serif;
            color: var(--text-dark);
            position: relative;
            font-weight: 500;
            font-size: 14px;
            text-decoration: none;
        }

        .action-btn:hover {
            background: var(--bg-light);
            color: var(--primary);
            transform: translateY(-2px);
        }

        .action-btn i {
            font-size: 18px;
            transition: transform 0.2s;
        }

        .action-btn:hover i {
            transform: scale(1.1);
        }

        .cart-badge {
            position: absolute;
            top: -4px;
            right: 2px;
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
            animation: bounceIn 0.5s ease;
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
            border-radius: var(--radius-sm);
            box-shadow: var(--shadow-md);
            min-width: 200px;
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
            transition: background 0.2s;
            border-bottom: 1px solid var(--border);
            text-decoration: none;
        }

        .dropdown-menu-custom a:last-child {
            border-bottom: none;
        }

        .dropdown-menu-custom a:hover {
            background: var(--bg-light);
            color: var(--primary);
            padding-left: 20px;
        }

        /* ============ HERO SECTION ============ */
        .hero-section {
            background: linear-gradient(135deg, #FDE8D4 0%, #FFF5EC 100%);
            padding: clamp(60px, 10vw, 100px) 0;
            position: relative; overflow: hidden;
            min-height: clamp(400px, 60vw, 600px);
            display: flex; align-items: center;
        }
        .hero-section::before {
            content: '🍪'; position: absolute;
            font-size: clamp(100px, 25vw, 300px);
            opacity: 0.05; bottom: -50px; right: -50px; pointer-events: none;
        }

        .hero-content { text-align: center; max-width: 900px; margin: 0 auto; width: 100%; }

        .big-brand-name {
            font-family: 'Playfair Display', serif;
            font-size: clamp(36px, 8vw, 80px);
            font-weight: 800; color: var(--primary);
            margin-bottom: 24px;
            letter-spacing: clamp(2px, 1vw, 8px);
            display: inline-block;
        }
        .big-brand-name span { display: inline-block; transition: transform 0.3s; }
        .big-brand-name span:hover { transform: translateY(-10px); color: var(--primary-dark); }

        .hero-tagline { font-size: clamp(15px, 3vw, 24px); color: var(--text-dark); margin-bottom: 16px; font-weight: 500; }
        .hero-description {
            font-size: clamp(13px, 2vw, 18px); color: var(--text-muted);
            margin-bottom: 32px; max-width: 600px; margin-left: auto; margin-right: auto; padding: 0 12px;
        }

        .hero-stats { display: flex; gap: clamp(16px, 4vw, 48px); justify-content: center; margin-bottom: 40px; flex-wrap: wrap; }
        .stat { text-align: center; }
        .stat h3 { font-size: clamp(22px, 5vw, 36px); color: var(--primary); margin-bottom: 6px; font-family: 'Inter', sans-serif; }
        .stat p { font-size: clamp(11px, 1.5vw, 14px); color: var(--text-muted); margin: 0; }

        .hero-buttons { display: flex; gap: 14px; justify-content: center; flex-wrap: wrap; }

        .btn-primary {
            background: var(--primary); color: white;
            padding: clamp(10px, 2vw, 14px) clamp(22px, 4vw, 36px);
            border-radius: 50px; font-weight: 600; transition: all 0.3s;
            display: inline-block; border: none; cursor: pointer; text-decoration: none;
            font-size: clamp(13px, 2vw, 16px);
        }
        .btn-primary:hover { background: var(--primary-dark); transform: translateY(-3px); box-shadow: var(--shadow-lg); }

        .btn-outline {
            border: 2px solid var(--primary); color: var(--primary);
            padding: clamp(10px, 2vw, 14px) clamp(22px, 4vw, 36px);
            border-radius: 50px; font-weight: 600; transition: all 0.3s;
            display: inline-block; background: transparent; text-decoration: none;
            font-size: clamp(13px, 2vw, 16px);
        }
        .btn-outline:hover { background: var(--primary); color: white; transform: translateY(-3px); }

        .decorative-cookie { position: absolute; opacity: 0.1; pointer-events: none; }
        .cookie-1 { font-size: 40px; top: 20%; left: 5%; animation: float 4s ease-in-out infinite; }
        .cookie-3 { font-size: 30px; top: 60%; left: 15%; animation: float 3.5s ease-in-out infinite; }

        /* ============ SECTION TITLE ============ */
        .section-title { text-align: center; font-size: clamp(24px, 5vw, 42px); margin-bottom: clamp(28px, 5vw, 60px); }
        .section-title span { color: var(--primary); }

        /* ============ FEATURE SECTION ============ */
        .feature-section { padding: clamp(48px, 8vw, 80px) 0; background: var(--bg-white); }
        .feature-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: clamp(14px, 3vw, 32px); }

        .feature-card {
            text-align: center; padding: clamp(18px, 3vw, 32px) clamp(14px, 2vw, 24px);
            transition: all 0.3s; border-radius: var(--radius-md); background: var(--bg-white);
        }
        .feature-card:hover { transform: translateY(-10px); box-shadow: var(--shadow-md); }

        .feature-icon {
            width: clamp(56px, 8vw, 80px); height: clamp(56px, 8vw, 80px);
            background: var(--primary-light); border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            margin: 0 auto 16px; transition: all 0.3s;
        }
        .feature-card:hover .feature-icon { background: var(--primary); transform: rotateY(360deg); }
        .feature-card:hover .feature-icon i { color: white; }
        .feature-icon i { font-size: clamp(22px, 4vw, 36px); color: var(--primary); transition: all 0.3s; }
        .feature-card h4 { font-family: 'Inter', sans-serif; font-size: clamp(14px, 2vw, 20px); margin-bottom: 10px; font-weight: 700; }
        .feature-card p { font-size: clamp(12px, 1.5vw, 14px); color: var(--text-muted); line-height: 1.6; }

        /* ============ PRODUK UNGGULAN ============ */
        .product-showcase { padding: clamp(48px, 8vw, 80px) 0; background: var(--bg-light); }
        .product-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: clamp(14px, 3vw, 32px); }

        .product-card {
            background: var(--bg-white); border-radius: var(--radius-md); overflow: hidden;
            transition: all 0.3s; box-shadow: var(--shadow-sm); opacity: 0; transform: translateY(30px);
        }
        .product-card.animate { animation: fadeInUp 0.6s ease forwards; }
        .product-card:nth-child(1).animate { animation-delay: 0.1s; }
        .product-card:nth-child(2).animate { animation-delay: 0.2s; }
        .product-card:nth-child(3).animate { animation-delay: 0.3s; }
        .product-card:hover { transform: translateY(-8px); box-shadow: var(--shadow-lg); }

        .product-image { height: clamp(160px, 22vw, 260px); overflow: hidden; position: relative; }
        .product-image::before { content: ''; position: absolute; inset: 0; background: rgba(0,0,0,0); transition: all 0.3s; z-index: 1; }
        .product-card:hover .product-image::before { background: rgba(0,0,0,0.1); }
        .product-image img { width: 100%; height: 100%; object-fit: cover; transition: transform 0.5s; }
        .product-card:hover .product-image img { transform: scale(1.1); }

        .product-info { padding: clamp(12px, 2vw, 20px); }
        .product-info h3 { font-family: 'Inter', sans-serif; font-size: clamp(14px, 2vw, 18px); margin-bottom: 6px; }
        .product-price { font-size: clamp(15px, 2.5vw, 22px); font-weight: 700; color: var(--primary); margin: 8px 0; }
        .product-ingredients { display: flex; flex-wrap: wrap; gap: 6px; margin: 8px 0; }
        .product-ingredients span { background: var(--bg-light); padding: 3px 10px; border-radius: 20px; font-size: 11px; color: var(--text-muted); }
        .btn-add-cart { width: 100%; background: var(--primary); color: white; border: none; padding: 11px; border-radius: var(--radius-sm); font-weight: 600; cursor: pointer; transition: all 0.3s; font-size: 14px; }
        .btn-add-cart:hover { background: var(--primary-dark); transform: translateY(-2px); }

        /* ============ TESTIMONI ============ */
        .testimonial-section { padding: clamp(48px, 8vw, 80px) 0; background: var(--bg-white); }
        .testimonial-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: clamp(14px, 3vw, 32px); }

        .testimonial-card {
            background: var(--bg-light); padding: clamp(18px, 3vw, 32px);
            border-radius: var(--radius-md); text-align: center;
            transition: all 0.3s; opacity: 0; transform: translateY(30px);
        }
        .testimonial-card.animate { animation: fadeInUp 0.6s ease forwards; }
        .testimonial-card:nth-child(1).animate { animation-delay: 0.1s; }
        .testimonial-card:nth-child(2).animate { animation-delay: 0.2s; }
        .testimonial-card:nth-child(3).animate { animation-delay: 0.3s; }
        .testimonial-card:hover { transform: translateY(-5px); box-shadow: var(--shadow-md); }
        .testimonial-card i { font-size: 34px; color: var(--accent); margin-bottom: 14px; display: block; transition: transform 0.3s; }
        .testimonial-card:hover i { transform: scale(1.2); }
        .testimonial-card p { font-style: italic; color: var(--text-muted); margin-bottom: 14px; font-size: clamp(12px, 1.8vw, 15px); line-height: 1.6; }
        .testimonial-card .name { font-weight: 700; color: var(--primary); font-size: 14px; }

        /* ============ FAQ ============ */
        .faq-section { padding: clamp(48px, 8vw, 80px) 0; background: var(--bg-light); }
        .faq-grid { max-width: 800px; margin: 0 auto; }

        .faq-item { background: var(--bg-white); margin-bottom: 12px; border-radius: var(--radius-sm); overflow: hidden; transition: all 0.3s; box-shadow: var(--shadow-sm); }
        .faq-item:hover { transform: translateX(5px); box-shadow: var(--shadow-md); }
        .faq-question { padding: clamp(14px, 2vw, 20px) clamp(16px, 2.5vw, 24px); font-weight: 600; cursor: pointer; display: flex; justify-content: space-between; align-items: center; transition: background 0.2s; font-size: clamp(13px, 2vw, 16px); gap: 12px; }
        .faq-question:hover { background: var(--bg-light); }
        .faq-answer { padding: 0 clamp(16px, 2.5vw, 24px); max-height: 0; overflow: hidden; transition: all 0.5s; color: var(--text-muted); line-height: 1.6; font-size: clamp(12px, 1.8vw, 15px); }
        .faq-item.active .faq-answer { padding: 0 clamp(16px, 2.5vw, 24px) 20px; max-height: 200px; }
        .faq-item.active .faq-question i { transform: rotate(180deg); }
        .faq-question i { transition: transform 0.3s; flex-shrink: 0; }

        /* ============ BRAND HERO SECTION ============ */
        .brand-hero-section {
            background: #ffff;
            padding: 0 0 clamp(36px, 6vw, 60px);
            position: relative; overflow: hidden;
        }

        .brand-bg-text {
            display: block; width: 100%; text-align: center;
            font-family: 'Playfair Display', serif;
            font-size: clamp(38px, 12vw, 200px);
            font-weight: 800;
            color: rgba(196, 122, 62, 0.10);
            white-space: nowrap; pointer-events: none; user-select: none;
            letter-spacing: clamp(-0.5px, -0.2vw, -2px);
            padding-top: 20px; 
            overflow: hidden;
            margin-bottom: 70px;

        }

        .brand-links-grid {
            display: grid; grid-template-columns: repeat(4, 1fr);
            gap: clamp(20px, 3vw, 40px);
            position: relative; z-index: 2;
            margin-top: clamp(-5px, -1vw, -10px);
        }

        .brand-col h5 {
            font-family: 'Inter', sans-serif; font-size: 11px; font-weight: 600;
            letter-spacing: 1.5px; text-transform: uppercase; color: var(--text-muted); margin: 0 0 14px;
        }

        .brand-col ul { list-style: none; margin: 0; padding: 0; }
        .brand-col ul li { margin-bottom: 10px; }
        .brand-col ul li a {
            font-size: clamp(13px, 1.8vw, 14px); color: var(--text-dark);
            text-decoration: none; opacity: 0.7; transition: all 0.2s; display: inline-block;
        }
        .brand-col ul li a:hover { opacity: 1; color: var(--primary); transform: translateX(4px); }

        .brand-jam-list { list-style: none; margin: 0; padding: 0; }
        .brand-jam-list li {
            display: flex; align-items: flex-start; gap: 10px;
            margin-bottom: 12px; font-size: clamp(12px, 1.6vw, 13px); color: var(--text-muted); line-height: 1.5;
        }
        .brand-jam-list li i { color: var(--primary); font-size: 13px; margin-top: 2px; flex-shrink: 0; width: 14px; }
        .brand-jam-list li span { color: var(--text-dark); opacity: 0.75; }

        /* Alert */
        .alert { padding: 12px 20px; border-radius: var(--radius-sm); margin-bottom: 20px; font-size: 14px; }
        .alert-success { background: #d4edda; color: #155724; border: 1px solid #c3e6cb; }
        .alert-danger { background: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; }

        /* Loading */
        .loading { position: fixed; inset: 0; background: white; display: flex; justify-content: center; align-items: center; z-index: 9999; transition: opacity 0.5s; }
        .loading.hide { opacity: 0; visibility: hidden; }
        .spinner { width: 50px; height: 50px; border: 4px solid var(--primary-light); border-top-color: var(--primary); border-radius: 50%; animation: spin 1s linear infinite; }

        /* ============ RESPONSIVE BREAKPOINTS ============ */
        @media (max-width: 1100px) {
            .feature-grid { grid-template-columns: repeat(2, 1fr); }
        }

        @media (max-width: 992px) {
            .product-grid,
            .testimonial-grid { grid-template-columns: repeat(2, 1fr); }
            .brand-links-grid { grid-template-columns: repeat(2, 1fr); }
            .header-container { padding: 12px 20px; gap: 16px; }
            .nav-links li a { padding: 8px 14px; font-size: 14px; }
            .action-btn { padding: 6px 14px; }
            .action-btn span { font-size: 13px; }
        }

        @media (max-width: 768px) {
            .container { padding: 0 16px; }
            .header-container { 
                flex-direction: column; 
                gap: 12px; 
                padding: 12px 16px;
            }
            .nav-links { 
                order: 2; 
                width: 100%; 
                justify-content: center;
                flex-wrap: wrap;
            }
            .header-actions { 
                order: 1; 
                width: 100%;
                justify-content: flex-end;
            }
            .logo { order: 0; }

            .feature-grid { grid-template-columns: repeat(2, 1fr); }
            .product-grid { grid-template-columns: 1fr; max-width: 460px; margin-left: auto; margin-right: auto; }
            .testimonial-grid { grid-template-columns: 1fr; max-width: 460px; margin-left: auto; margin-right: auto; }

            .brand-links-grid { grid-template-columns: repeat(2, 1fr); gap: 24px; }
            .brand-jam-list li { justify-content: flex-start; }
        }

        @media (max-width: 480px) {
            .nav-links li a { padding: 6px 12px; font-size: 12px; }
            .action-btn span { display: none; }
            .action-btn { padding: 8px 12px; }
            .action-btn i { font-size: 16px; }

            .feature-grid { grid-template-columns: 1fr; max-width: 340px; margin-left: auto; margin-right: auto; }
            .hero-stats { gap: 14px; }

            .brand-links-grid { grid-template-columns: 1fr 1fr; gap: 16px; }
        }

        @media (max-width: 360px) {
            .brand-links-grid { grid-template-columns: 1fr; }
            .hero-stats { flex-direction: column; align-items: center; }
            .hero-buttons { flex-direction: column; align-items: center; }
        }
    </style>
</head>
<body>

    <!-- Loading Animation -->
    <div class="loading" id="loading">
        <div class="spinner"></div>
    </div>

    <!-- HEADER -->
    <header class="main-header">
        <div class="header-container">
            <div class="logo">
                <a href="{{ route('beranda') }}">
                    <img src="{{ asset('image/nyonyacrumb.jpeg') }}" alt="Nyonya Crumb">
                </a>
            </div>

            <ul class="nav-links">
                <li><a href="{{ route('beranda') }}">Beranda</a></li>
                <li><a href="{{ route('produk.all') }}">Produk</a></li>
                <li><a href="{{ route('cara.pesan') }}">Cara Pesan</a></li>
                <li><a href="{{ route('contact') }}">Kontak</a></li>
            </ul>

            <div class="header-actions">
                <a href="{{ route('v_order.cart') }}" class="action-btn">
                    <i class="fa fa-shopping-bag"></i>
                    <span>Keranjang</span>
                    @php
                        $cartCount = 0;
                        if(Auth::check()) {
                            $customer = \App\Models\Customer::firstOrCreate(
                                ['user_id' => Auth::id()],
                                ['alamat' => '', 'pos' => '']
                            );
                            $order = \App\Models\Order::where('customer_id', $customer->id)
                                ->where('status', 'pending')
                                ->first();
                            if ($order) {
                                $cartCount = $order->orderItems()->sum('quantity');
                            }
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
    </header>

    @yield('content')

    @if(request()->routeIs('beranda') || request()->is('/'))
    <!-- HERO SECTION -->
    <section class="hero-section">
        <div class="decorative-cookie cookie-1">🍪</div>
        <div class="decorative-cookie cookie-3">🍩</div>

        <div class="container">
            <div class="hero-content">
                <h1 class="big-brand-name animate-zoomIn">
                    <span>N</span><span>Y</span><span>O</span><span>N</span><span>Y</span><span>A</span>
                    <span style="margin: 0 4px"></span>
                    <span>C</span><span>R</span><span>U</span><span>M</span><span>B</span>
                </h1>
                <p class="hero-tagline animate-fadeInUp" style="animation-delay: 0.2s;">✨ Homemade Cookies with Love ✨</p>
                <p class="hero-description animate-fadeInUp" style="animation-delay: 0.3s;">Setiap gigitan bercerita. Nyonya Crumb menghadirkan kue kering homemade dengan cita rasa otentik, bahan pilihan terbaik, dan diproduksi dengan standar kebersihan tertinggi.</p>
                <div class="hero-stats stagger-child">
                    <div class="stat">
                        <h3>10.000+</h3>
                        <p>Pelanggan Bahagia</p>
                    </div>
                    <div class="stat">
                        <h3>100%</h3>
                        <p>Homemade Quality</p>
                    </div>
                </div>
                <div class="hero-buttons animate-fadeInUp" style="animation-delay: 0.5s;">
                    <a href="{{ route('produk.all') }}" class="btn-primary pulse-animation">Belanja Sekarang →</a>
                </div>
            </div>
        </div>
    </section>

    <!-- SECTION FITUR -->
    <section class="feature-section reveal">
        <div class="container">
            <h2 class="section-title">Kenapa Memilih <span>Nyonya Crumb</span>?</h2>
            <div class="feature-grid">
                <div class="feature-card">
                    <div class="feature-icon"><i class="fa fa-leaf"></i></div>
                    <h4>Bahan Alami</h4>
                    <p>Tanpa pengawet, tanpa pewarna buatan. 100% bahan alami pilihan terbaik.</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon"><i class="fa fa-heartbeat"></i></div>
                    <h4>Rendah Gula</h4>
                    <p>Pilihan gula aren & stevia untuk hidup lebih sehat tanpa mengurangi rasa.</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon"><i class="fa fa-shield"></i></div>
                    <h4>Kualitas Premium</h4>
                    <p>Bahan pilihan, diproses higienis dengan standar terbaik dan sertifikasi halal.</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon"><i class="fa fa-truck"></i></div>
                    <h4>Pengiriman Cepat</h4>
                    <p>Packing aman, pengiriman cepat ke seluruh Indonesia dengan ekspedisi terpercaya.</p>
                </div>
            </div>
        </div>
    </section>

   <!-- PRODUK UNGGULAN -->
<section class="product-showcase reveal">
    <div class="container">
        <h2 class="section-title">Produk <span>Terlaris</span></h2>
        <div class="product-grid">
            @php
                $produkTerlaris = App\Models\Produk::with('kategori')
                    ->where('status', 1)
                    ->orderBy('created_at', 'desc')
                    ->take(3)
                    ->get();
            @endphp

            @forelse($produkTerlaris as $index => $produk)
            <div class="product-card" data-delay="{{ $index * 0.1 }}">
                <div class="product-image">
                    @php
                        $fotoUrl = asset('frontend/images/default-product.jpg');
                        if($produk->foto) {
                            $fotoUrl = asset('storage/img-produk/' . $produk->foto);
                        } elseif($produk->fotoProduk->first()) {
                            $fotoUrl = asset('storage/img-produk/' . $produk->fotoProduk->first()->foto);
                        }
                    @endphp
                    <img src="{{ $fotoUrl }}" alt="{{ $produk->nama_produk }}">
                </div>
                <div class="product-info">
                    <h3>{{ $produk->nama_produk }}</h3>
                    <div class="product-price">Rp {{ number_format($produk->harga, 0, ',', '.') }}</div>
                    <div class="product-ingredients">
                        @php $bahanArray = explode(',', $produk->bahan ?? 'Tepung,Mentega,Gula'); @endphp
                        @foreach(array_slice($bahanArray, 0, 3) as $bahan)
                            <span>{{ trim($bahan) }}</span>
                        @endforeach
                    </div>
                    <a href="{{ route('produk.detail', $produk->id) }}" class="btn-add-cart text-center" style="display: block; text-decoration: none;">Lihat Detail</a>
                </div>
            </div>
            @empty
            <div class="col-12 text-center">
                <p>Belum ada produk tersedia.</p>
            </div>
            @endforelse
        </div>
    </div>
</section>

    <!-- TESTIMONI -->
    <section class="testimonial-section reveal">
        <div class="container">
            <h2 class="section-title">Apa Kata <span>Pelanggan</span></h2>
            <div class="testimonial-grid">
                @php
                    $latestReviews = \App\Models\Review::with('user', 'produk')->orderBy('created_at', 'desc')->take(3)->get();
                @endphp

                @forelse($latestReviews as $index => $review)
                    <div class="testimonial-card">
                        <i class="fa fa-quote-left"></i>
                        <div style="color: #FFB800; font-size: 14px; margin-bottom: 10px;">
                            @for($i=1; $i<=5; $i++)
                                @if($i <= $review->rating)
                                    <i class="fa fa-star"></i>
                                @else
                                    <i class="fa fa-star-o"></i>
                                @endif
                            @endfor
                        </div>
                        <p>"{{ Str::limit($review->comment, 100) }}"</p>
                        <div class="name" style="margin-bottom: 4px;">— {{ $review->user->nama ?? 'Anonim' }}</div>
                        <div style="font-size: 11px; color: var(--text-light);">Membeli: {{ $review->produk->nama_produk ?? 'Produk' }}</div>
                    </div>
                @empty
                    <div class="testimonial-card">
                        <i class="fa fa-quote-left"></i>
                        <p>"Kue kering Nyonya Crumb selalu menjadi pilihan utama keluarga kami karena rasanya yang premium."</p>
                        <div class="name">— Pelanggan Setia</div>
                    </div>
                @endforelse
            </div>
        </div>
    </section>

    <!-- FAQ -->
    <section class="faq-section reveal">
        <div class="container">
            <h2 class="section-title">Pertanyaan yang <span>Sering Diajukan</span></h2>
            <div class="faq-grid">
                <div class="faq-item">
                    <div class="faq-question">
                        Apakah cookies ini menggunakan bahan pengawet?
                        <i class="fa fa-chevron-down"></i>
                    </div>
                    <div class="faq-answer">Tidak, semua cookies Nyonya Crumb dibuat tanpa pengawet buatan. Kami menggunakan bahan alami dan diproduksi secara homemade setiap hari.</div>
                </div>
                <div class="faq-item">
                    <div class="faq-question">
                        Berapa lama masa simpan cookies?
                        <i class="fa fa-chevron-down"></i>
                    </div>
                    <div class="faq-answer">Disarankan dikonsumsi dalam 2 minggu dalam kemasan tertutup rapat. Untuk menjaga kerenyahan, simpan di wadah kedap udara.</div>
                </div>
                <div class="faq-item">
                    <div class="faq-question">
                        Apakah bisa request cookies untuk acara spesial?
                        <i class="fa fa-chevron-down"></i>
                    </div>
                    <div class="faq-answer">Tentu, kami menerima pesanan custom untuk pernikahan, ulang tahun, atau hampers. Hubungi customer service kami.</div>
                </div>
                <div class="faq-item">
                    <div class="faq-question">
                        Bagaimana cara pemesanan dan pembayaran?
                        <i class="fa fa-chevron-down"></i>
                    </div>
                    <div class="faq-answer">Anda bisa pesan langsung melalui website ini, pilih produk, lalu checkout. Pembayaran via transfer bank, e-wallet, atau COD (tersedia wilayah tertentu).</div>
                </div>
            </div>
        </div>
    </section>

    <!-- BRAND HERO SECTION -->
    <section class="brand-hero-section reveal">
        <div class="brand-bg-text">Nyonya Crumb</div>
        <div class="container">
            <div class="brand-links-grid">
                <div class="brand-col">
                    <h5>Jelajahi</h5>
                    <ul>
                        <li><a href="{{ route('beranda') }}">Beranda</a></li>
                        <li><a href="{{ route('produk.all') }}">Semua Produk</a></li>
                        <li><a href="{{ route('cara.pesan') }}">Cara Pesan</a></li>
                        <li><a href="{{ route('contact') }}">Kontak</a></li>
                    </ul>
                </div>
                <div class="brand-col">
                    <h5>Toko</h5>
                    <ul>
                        <li><a href="{{ route('produk.all') }}">Produk Terbaru</a></li>
                        <li><a href="{{ route('produk.all') }}">Produk Terlaris</a></li>
                        <li><a href="#">Hampers Special</a></li>
                        <li><a href="#">Pesanan Custom</a></li>
                    </ul>
                </div>
                <div class="brand-col">
                    <h5>Bantuan</h5>
                    <ul>
                        <li><a href="#">FAQ</a></li>
                        <li><a href="#">Kebijakan Pengiriman</a></li>
                        <li><a href="#">Syarat & Ketentuan</a></li>
                        <li><a href="#">Hubungi Kami</a></li>
                    </ul>
                </div>
                <div class="brand-col social-col">
                    <h5>Ikuti Kami</h5>
                    <div class="social-links-brand">
                        <a href="#" class="social-icon-brand"><i class='bx bxl-instagram'></i></a>
                        <a href="#" class="social-icon-brand"><i class='bx bxl-facebook'></i></a>
                        <a href="#" class="social-icon-brand"><i class='bx bxl-tiktok'></i></a>
                    </div>
                    <p class="mt-3 text-muted">Dapatkan inspirasi kue harian dan promo eksklusif.</p>
                </div>
            </div>
        </div>
    </section>
    @endif


    <footer class="text-white py-4" style="background: var(--primary);">
        <div class="container text-center">
            <p class="mb-0">&copy; 2023 Nyonya Crumb. All rights reserved.</p>
        </div>
    </footer>

    <!-- JS SCRIPTS -->
    <script src="{{ asset('frontend/js/jquery.min.js') }}"></script>
    <script src="{{ asset('frontend/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('frontend/js/slick.min.js') }}"></script>
    <script src="{{ asset('frontend/js/main.js') }}"></script>

    <script>
        $(document).ready(function(){
            setTimeout(function() { $('#loading').addClass('hide'); }, 500);

            $('.faq-question').click(function(){
                $(this).parent().toggleClass('active');
                $(this).find('i').toggleClass('fa-chevron-down fa-chevron-up');
            });

            setTimeout(function() { $('.alert').fadeOut('slow'); }, 3000);

            function checkReveal() {
                $('.reveal').each(function() {
                    if ($(this).offset().top < $(window).scrollTop() + $(window).height() - 100) {
                        $(this).addClass('active');
                    }
                });
            }

            function checkProductCards() {
                $('.product-card').each(function() {
                    if ($(this).offset().top < $(window).scrollTop() + $(window).height() - 100) {
                        $(this).addClass('animate');
                    }
                });
            }

            function checkTestimonialCards() {
                $('.testimonial-card').each(function() {
                    if ($(this).offset().top < $(window).scrollTop() + $(window).height() - 100) {
                        $(this).addClass('animate');
                    }
                });
            }

            checkReveal(); checkProductCards(); checkTestimonialCards();

            $(window).on('scroll', function() {
                checkReveal(); checkProductCards(); checkTestimonialCards();
            });
        });
    </script>


    @yield('scripts')
</body>
</html>