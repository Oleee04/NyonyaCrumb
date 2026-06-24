<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('image/nyonyacrumb.png') }}">
    <title> Nyonya Crumb - Cookies</title>

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,600;1,300;1,400&family=DM+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">

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

        :root {
            --primary: #8D6E63;
            --primary-dark: #5D4037;
            --primary-light: #C6A68A;
            --primary-gold: #D4A373;
            --bg-creme: #FCF8F4;
            --bg-white: #FFFFFF;
            --text-dark: #2A1A17;
            --text-muted: #705349;
            --text-light: #C6A68A;
            --border: rgba(141, 110, 99, 0.15);
            --shadow-sm: 0 8px 30px rgba(62, 39, 35, 0.03);
            --shadow-md: 0 20px 40px rgba(62, 39, 35, 0.06);
            --shadow-lg: 0 30px 60px rgba(62, 39, 35, 0.1);
            --radius-sm: 4px;
            --radius-md: 12px;
        }

        body {
            background: var(--bg-creme);
            font-family: 'DM Sans', sans-serif;
            color: var(--text-dark);
            overflow-x: hidden;
            line-height: 1.6;
        }

        h1, h2, h3, h4, h5, h6 {
            font-family: 'Cormorant Garamond', serif;
            font-weight: 600;
            letter-spacing: -0.2px;
        }

        canvas#waveCanvas {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            pointer-events: none;
            z-index: 0;
        }

        /* Container */
        .container {
            max-width: 1280px;
            margin: 0 auto;
            padding: 0 32px;
            position: relative;
            z-index: 2;
        }

        /* ============ HEADER ============ */
        .nc-nav {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 1000;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 28px 80px 28px 32px;
            background: transparent;
            border-bottom: 1px solid transparent;
            transition: all 0.4s cubic-bezier(0.16, 1, 0.3, 1);
        }
        .nc-nav.scrolled {
            padding: 16px 80px 16px 32px;
            background: rgba(252, 248, 244, 0.85);
            backdrop-filter: blur(15px);
            -webkit-backdrop-filter: blur(15px);
            border-bottom: 1px solid rgba(141, 110, 99, 0.08);
            box-shadow: 0 4px 30px rgba(62, 39, 35, 0.03);
        }

        /* Logo container */
        .logo {
            flex-shrink: 0;
        }
        .logo a {
            display: flex;
            align-items: center;
            gap: 14px;
            text-decoration: none;
        }
        .logo img {
            height: 48px;
            width: auto;
            transition: transform 0.3s ease;
        }
        .logo img:hover {
            transform: scale(1.02);
        }
        .logo-text {
            display: flex;
            flex-direction: column;
            line-height: 1.1;
        }
        .logo-text-main {
            font-family: 'Cormorant Garamond', serif;
            font-size: 20px;
            font-weight: 600;
            letter-spacing: 1.5px;
            color: var(--text-dark);
            transition: color 0.3s ease;
        }
        .logo-text-sub {
            font-family: 'DM Sans', sans-serif;
            font-size: 9px;
            letter-spacing: 3.5px;
            text-transform: uppercase;
            color: var(--text-muted);
            font-weight: 500;
        }
        .logo a:hover .logo-text-main {
            color: var(--primary);
        }

        .nc-nav-links {
            display: flex;
            gap: 48px;
            list-style: none;
            margin: 0;
            padding: 0;
        }
        .nc-nav-links a {
            font-size: 11px;
            letter-spacing: 2.5px;
            text-transform: uppercase;
            color: var(--text-dark);
            text-decoration: none;
            font-weight: 500;
            opacity: 0.7;
            transition: 0.3s;
            position: relative;
        }
        .nc-nav-links a::after {
            content: '';
            position: absolute;
            bottom: -6px;
            left: 0;
            width: 0;
            height: 1.2px;
            background: var(--primary);
            transition: 0.3s;
        }
        .nc-nav-links a:hover {
            opacity: 1;
        }
        .nc-nav-links a:hover::after {
            width: 100%;
        }

        .header-actions {
            display: flex;
            align-items: center;
            gap: 32px;
        }

        .nc-action-link {
            font-size: 11px;
            letter-spacing: 2px;
            text-transform: uppercase;
            color: var(--text-dark);
            text-decoration: none;
            font-weight: 600;
            transition: 0.3s;
            opacity: 0.8;
        }
        .nc-action-link:hover {
            opacity: 1;
            color: var(--primary);
        }

        .nc-dropdown {
            position: relative;
        }
        .nc-dropdown-menu {
            display: block;
            visibility: hidden;
            pointer-events: none;
            position: absolute;
            top: calc(100% + 10px);
            right: 0;
            background: var(--bg-white);
            min-width: 220px;
            padding: 15px 0;
            box-shadow: 0 15px 35px rgba(0,0,0,0.12);
            border-radius: var(--radius-sm);
            z-index: 9999;
            border: 1px solid var(--border);
            opacity: 0;
            transform: translateY(8px);
            transition: opacity 0.25s ease, transform 0.25s ease, visibility 0.25s;
        }
        .nc-dropdown.open .nc-dropdown-menu {
            visibility: visible;
            pointer-events: auto;
            opacity: 1;
            transform: translateY(0);
        }
        .nc-dropdown-trigger {
            cursor: pointer;
            user-select: none;
        }
        .nc-dropdown-menu a {
            display: flex;
            align-items: center;
            padding: 12px 25px;
            font-size: 11px;
            letter-spacing: 1.5px;
            text-transform: uppercase;
            color: var(--text-dark);
            text-decoration: none;
            transition: 10.3s;
            font-weight: 600;
        }
        .nc-dropdown-menu a i {
            color: var(--text-muted);
            transition: 0.3s;
        }
        .nc-dropdown-menu a:hover {
            background: var(--bg-creme);
            color: var(--primary);
            padding-left: 32px;
        }
        .nc-dropdown-menu a:hover i {
            color: var(--primary);
        }

        .section-padding { padding: 100px 0; }

        /* ============ HERO SECTION ============ */
        .hero-section {
            min-height: 100vh;
            display: flex;
            align-items: center;
            padding: 140px 0 100px;
            position: relative;
            background: transparent;
            overflow: hidden;
        }

        .hero-eyebrow {
            display: flex;
            align-items: center;
            gap: 16px;
            margin-bottom: 24px;
            opacity: 0.8;
        }
        .hero-eyebrow .line {
            width: 25px;
            height: 1px;
            background: var(--primary);
        }
        .hero-eyebrow span {
            font-size: 11px;
            letter-spacing: 3px;
            text-transform: uppercase;
            font-weight: 600;
            color: var(--primary);
        }

        .hero-title {
            font-family: 'Cormorant Garamond', serif;
            font-size: clamp(44px, 6vw, 84px);
            line-height: 1.1;
            margin-bottom: 24px;
            color: var(--text-dark);
            font-weight: 500;
        }
        .hero-title span { color: var(--primary-gold); font-style: italic; font-weight: 600; }

        .hero-desc {
            font-size: 15px;
            line-height: 1.8;
            color: var(--text-muted);
            max-width: 540px;
            margin-bottom: 40px;
            font-weight: 400;
        }

        .hero-btns {
            display: flex;
            gap: 16px;
        }

        .btn-nc-dark {
            background: var(--text-dark);
            color: #fff;
            padding: 16px 36px;
            border-radius: 30px;
            font-size: 11px;
            letter-spacing: 2px;
            text-transform: uppercase;
            text-decoration: none;
            transition: all 0.3s ease;
            font-weight: 700;
            display: inline-block;
            border: none;
            cursor: pointer;
            box-shadow: 0 10px 20px rgba(62, 39, 35, 0.15);
        }
        .btn-nc-dark:hover {
            background: var(--primary);
            transform: translateY(-2px);
            box-shadow: 0 15px 25px rgba(141, 110, 99, 0.25);
        }

        .btn-nc-outline {
            border: 1px solid rgba(93, 64, 55, 0.3);
            color: var(--text-dark);
            padding: 16px 36px;
            border-radius: 30px;
            font-size: 11px;
            letter-spacing: 2px;
            text-transform: uppercase;
            text-decoration: none;
            transition: all 0.3s ease;
            font-weight: 700;
            background: transparent;
        }
        .btn-nc-outline:hover {
            border-color: var(--text-dark);
            background: #fff;
            transform: translateY(-2px);
        }

        /* Floating Showcase on Hero Right */
        .hero-image-wrapper {
            position: relative;
            width: 100%;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .hero-image-bg-glow {
            position: absolute;
            width: 80%;
            height: 80%;
            background: radial-gradient(circle, rgba(198,166,138,0.18) 0%, rgba(253,249,245,0) 70%);
            z-index: 0;
            pointer-events: none;
        }
        .hero-floating-img {
            max-width: 90%;
            height: auto;
            border-radius: 40px 180px 40px 180px;
            box-shadow: 0 30px 60px rgba(62, 39, 35, 0.15);
            border: 2px solid #fff;
            animation: float 6s ease-in-out infinite;
            z-index: 1;
            position: relative;
            background: #fff;
        }
        @keyframes float {
            0% { transform: translateY(0px) rotate(0deg); }
            50% { transform: translateY(-15px) rotate(1deg); }
            100% { transform: translateY(0px) rotate(0deg); }
        }
        .floating-badge {
            position: absolute;
            bottom: 20px;
            left: 20px;
            background: var(--bg-white);
            border: 1px solid var(--border);
            border-radius: 50%;
            width: 100px;
            height: 100px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            box-shadow: 0 15px 35px rgba(62, 39, 35, 0.08);
            z-index: 2;
            animation: rotateBadge 20s linear infinite;
        }
        .badge-number {
            font-family: 'Cormorant Garamond', serif;
            font-size: 22px;
            font-weight: 700;
            color: var(--text-dark);
            line-height: 1;
        }
        .badge-text {
            font-size: 8px;
            letter-spacing: 1px;
            text-transform: uppercase;
            font-weight: 700;
            color: var(--primary);
            text-align: center;
            margin-top: 2px;
            line-height: 1.2;
        }
        @keyframes rotateBadge {
            0% { transform: rotate(0deg) scale(1); }
            50% { transform: rotate(5deg) scale(1.03); }
            100% { transform: rotate(0deg) scale(1); }
        }

        /* Section Title */
        .section-title {
            font-size: clamp(34px, 6vw, 52px);
            text-align: center;
            margin-bottom: 58px;
            font-weight: 500;
            letter-spacing: -0.5px;
            color: var(--text-dark);
        }
        .section-title span {
            font-style: italic;
            font-weight: 600;
            color: var(--text-light);
        }

        /* Artisan Feature Grid */
        .feature-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 40px;
            margin: 120px 0 100px;
        }
        .feature-card {
            background: #fff;
            padding: 70px 25px 65px;
            text-align: center;
            border-radius: 140px 140px 30px 30px; /* Match Artisan Arch */
            transition: all 0.5s cubic-bezier(0.165, 0.84, 0.44, 1);
            border: 1px solid #f3efec;
            position: relative;
            box-shadow: 0 10px 30px rgba(141, 110, 99, 0.05);
            display: flex;
            flex-direction: column;
            justify-content: flex-start;
        }
        .feature-card:hover {
            transform: translateY(-12px);
            box-shadow: 0 30px 60px rgba(141, 110, 99, 0.12);
            border-color: var(--primary-light);
        }
        .feature-icon {
            position: absolute;
            top: -35px;
            left: 50%;
            transform: translateX(-50%) rotate(45deg);
            width: 70px;
            height: 70px;
            background: var(--primary);
            color: #fff;
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 10px 25px rgba(141, 110, 99, 0.3);
            border: 3px solid #fff;
            transition: all 0.4s cubic-bezier(0.34, 1.56, 0.64, 1);
        }
        .feature-card:hover .feature-icon {
            background: var(--primary-dark);
            transform: translateX(-50%) rotate(225deg); /* Cool flip animation */
        }
        .feature-icon i {
            transform: rotate(-45deg);
            font-size: 24px;
            transition: transform 0.4s ease;
        }
        .feature-card:hover .feature-icon i {
            transform: rotate(-225deg) scale(1.2);
        }
        .feature-card h4 {
            font-size: 24px;
            margin-bottom: 12px;
            font-family: 'Cormorant Garamond', serif;
            font-weight: 700;
            color: var(--text-dark);
            letter-spacing: 0.5px;
        }
        .feature-card p {
            color: #8a7b73;
            font-size: 14px;
            line-height: 1.7;
            margin: 0;
            padding: 0 10px;
        }

        /* Hotto Style Product Showcase */
        .hotto-showcase {
            background: transparent;
            padding: 100px 0;
            border-bottom: 1px solid var(--border);
            position: relative;
            overflow: hidden;
        }
        
        .product-tabs-wrapper {
            display: flex;
            justify-content: center;
            gap: 15px;
            margin-bottom: 60px;
            flex-wrap: wrap;
            position: relative;
            z-index: 10;
        }
        
        .product-tab-btn {
            background: rgba(255, 255, 255, 0.6);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border: 1px solid var(--border);
            padding: 14px 32px;
            font-family: 'DM Sans', sans-serif;
            font-weight: 700;
            font-size: 12px;
            color: var(--text-dark);
            letter-spacing: 1.5px;
            text-transform: uppercase;
            cursor: pointer;
            transition: all 0.4s cubic-bezier(0.16, 1, 0.3, 1);
            border-radius: 100px;
        }
        
        .product-tab-btn:hover {
            color: var(--primary);
            background: #fff;
            border-color: var(--primary-light);
            transform: translateY(-2px);
        }
        
        .product-tab-btn.active {
            background: var(--primary-dark);
            color: #fff;
            border-color: var(--primary-dark);
            box-shadow: 0 10px 25px rgba(62, 39, 35, 0.15);
        }
        
        .hotto-product-tab-content {
            display: none;
            animation: fadeInTab 0.8s cubic-bezier(0.16, 1, 0.3, 1) forwards;
        }
        
        .hotto-product-tab-content.active {
            display: block;
        }
        
        @keyframes fadeInTab {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        .hotto-grid {
            display: grid;
            grid-template-columns: 1fr 1.1fr;
            gap: 60px;
            align-items: center;
            margin-bottom: 60px;
            text-align: left;
        }
        
        .hotto-left {
            text-align: left;
            background: rgba(255, 255, 255, 0.5);
            backdrop-filter: blur(15px);
            -webkit-backdrop-filter: blur(15px);
            padding: 48px;
            border-radius: 30px;
            border: 1px solid rgba(255, 255, 255, 0.6);
            box-shadow: var(--shadow-md);
        }
        
        .hotto-eyebrow {
            font-family: 'DM Sans', sans-serif;
            font-size: 11px;
            font-weight: 700;
            color: var(--primary);
            letter-spacing: 3px;
            text-transform: uppercase;
            margin-bottom: 24px;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        
        .hotto-title {
            font-family: 'Cormorant Garamond', serif;
            font-size: clamp(36px, 5vw, 56px);
            font-weight: 600;
            color: var(--text-dark);
            margin: 0 0 20px 0;
            line-height: 1.15;
        }
        
        .hotto-desc {
            font-family: 'DM Sans', sans-serif;
            font-size: 15px;
            line-height: 1.8;
            color: var(--text-muted);
            margin-bottom: 35px;
        }
        
        .hotto-btn-detail {
            background: var(--primary-dark);
            color: #fff;
            padding: 16px 36px;
            font-family: 'DM Sans', sans-serif;
            font-weight: 700;
            font-size: 11px;
            letter-spacing: 2px;
            text-transform: uppercase;
            border-radius: 30px;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 10px;
            transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
            box-shadow: 0 8px 20px rgba(93, 64, 55, 0.15);
        }
        
        .hotto-btn-detail:hover {
            background: var(--primary);
            transform: translateY(-3px);
            box-shadow: 0 15px 30px rgba(141, 110, 99, 0.25);
            color: #fff;
        }
        
        .hotto-right-img {
            border-radius: 30px 150px 30px 150px;
            overflow: hidden;
            box-shadow: 0 25px 55px rgba(62, 39, 35, 0.12);
            border: 2px solid #fff;
            aspect-ratio: 16/11;
            background: #fff;
            transition: all 0.5s ease;
        }
        
        .hotto-right-img img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.8s cubic-bezier(0.16, 1, 0.3, 1);
        }
        
        .hotto-right-img:hover {
            transform: translateY(-5px);
            box-shadow: 0 35px 70px rgba(62, 39, 35, 0.18);
        }
        .hotto-right-img:hover img {
            transform: scale(1.05);
        }
        
        /* About Image Hover Zoom */
        .about-img-container {
            position: relative;
            z-index: 1;
            border-radius: 120px 20px 120px 20px;
            overflow: hidden;
            box-shadow: var(--shadow-md);
            aspect-ratio: 16/10;
            background: var(--bg-creme);
            border: 1px solid var(--border);
        }
        .about-img-container img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.8s cubic-bezier(0.16, 1, 0.3, 1);
        }
        .about-img-container:hover img {
            transform: scale(1.05);
        }
        
        /* Key Ingredients Section */
        .hotto-divider {
            position: relative;
            text-align: center;
            margin: 60px 0 45px;
        }
        
        .hotto-divider::before {
            content: "";
            position: absolute;
            top: 50%;
            left: 0;
            width: 100%;
            height: 1px;
            background: var(--border);
            z-index: 1;
        }
        
        .hotto-divider-text {
            position: relative;
            background: var(--bg-creme);
            padding: 0 24px;
            z-index: 2;
            font-family: 'DM Sans', sans-serif;
            font-size: 11px;
            font-weight: 700;
            color: var(--primary-light);
            letter-spacing: 3px;
            text-transform: uppercase;
            display: inline-block;
        }
        
        .hotto-ingredients-grid {
            display: flex;
            flex-wrap: wrap;
            gap: 30px;
            justify-content: center;
            max-width: 1000px;
            margin: 0 auto;
        }
        
        .hotto-ingredient-card {
            background: rgba(255, 255, 255, 0.45);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.5);
            border-radius: 80px 20px 80px 20px;
            padding: 30px 20px;
            transition: all 0.4s cubic-bezier(0.16, 1, 0.3, 1);
            text-align: center;
            flex: 0 1 227px;
            box-sizing: border-box;
        }
        .hotto-ingredient-card:hover {
            background: rgba(255, 255, 255, 0.85);
            transform: translateY(-5px);
            border-color: var(--primary-light);
            box-shadow: var(--shadow-md);
        }
        
        .hotto-ingredient-circle {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            overflow: hidden;
            margin: 0 auto 20px;
            border: 4px solid #fff;
            box-shadow: 0 10px 25px rgba(141, 110, 99, 0.08);
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        }
        
        .hotto-ingredient-card:hover .hotto-ingredient-circle {
            transform: scale(1.08);
            box-shadow: 0 15px 30px rgba(141, 110, 99, 0.15);
        }
        
        .hotto-ingredient-circle img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        
        .hotto-ingredient-card h4 {
            font-family: 'Cormorant Garamond', serif;
            font-size: 21px;
            font-weight: 700;
            color: var(--text-dark);
            margin: 0 0 10px 0;
        }
        
        .hotto-ingredient-card p {
            font-family: 'DM Sans', sans-serif;
            font-size: 13px;
            line-height: 1.65;
            color: var(--text-muted);
            margin: 0;
        }
        
        @media (max-width: 1024px) {
            .hotto-ingredients-grid {
                gap: 30px;
                max-width: 500px;
            }
        }
        
        @media (max-width: 900px) {
            .hotto-grid {
                grid-template-columns: 1fr;
                gap: 40px;
            }
            .hotto-right-img {
                max-width: 550px;
                margin: 0 auto;
            }
            .hotto-left {
                text-align: center;
            }
            .hotto-eyebrow {
                justify-content: center;
            }
        }
        
        @media (max-width: 480px) {
            .hotto-ingredients-grid {
                gap: 30px;
            }
            .hotto-ingredient-card {
                flex: 1 1 100%;
                max-width: 280px;
            }
        }

        /* Creative Product Grid */
        .product-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 60px;
            margin: 60px 0 80px;
        }
        .product-card {
            background: transparent;
            border: none;
            transition: all 0.6s cubic-bezier(0.34, 1.56, 0.64, 1);
            position: relative;
            opacity: 0;
            transform: translateY(40px);
        }
        .product-card.animate {
            opacity: 1;
            transform: translateY(0);
        }
        .product-image {
            border-radius: 180px 180px 30px 30px; /* The Artisan Arch */
            overflow: hidden;
            background: #fff;
            position: relative;
            box-shadow: 0 20px 50px rgba(141, 110, 99, 0.12);
            aspect-ratio: 1 / 1.3;
            transition: all 0.6s ease;
        }
        .product-card:hover .product-image {
            transform: translateY(-10px);
            box-shadow: 0 30px 60px rgba(141, 110, 99, 0.2);
        }
        .product-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 1.2s cubic-bezier(0.165, 0.84, 0.44, 1);
        }
        .product-card:hover .product-image img {
            transform: scale(1.15);
        }
        .product-price {
            position: absolute;
            top: 20px;
            right: 20px;
            width: 70px;
            height: 70px;
            background: var(--bg-creme);
            border: 2px solid #fff;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 12px;
            font-weight: 800;
            color: var(--primary-dark);
            box-shadow: 0 10px 20px rgba(141, 110, 99, 0.15);
            z-index: 5;
            transform: rotate(-15deg);
            transition: all 0.4s cubic-bezier(0.34, 1.56, 0.64, 1);
        }
        .product-card:hover .product-price {
            transform: rotate(0deg) scale(1.1);
            background: var(--primary);
            color: #fff;
        }
        .product-info {
            padding: 35px 15px 0;
            text-align: center;
        }
        .product-info h3 {
            font-family: 'Cormorant Garamond', serif;
            font-size: 32px;
            font-weight: 600;
            margin-bottom: 8px;
            color: var(--text-dark);
            transition: 0.3s;
        }
        .product-card:hover h3 {
            color: var(--primary);
        }
        .product-ingredients {
            display: flex;
            justify-content: center;
            gap: 15px;
            margin-bottom: 25px;
        }
        .product-ingredients span {
            font-size: 10px;
            text-transform: uppercase;
            letter-spacing: 2px;
            color: #b5a499;
            font-weight: 500;
            position: relative;
        }
        .product-ingredients span:not(:last-child)::after {
            content: "";
            position: absolute;
            right: -10px;
            top: 50%;
            width: 4px;
            height: 4px;
            background: var(--primary-light);
            border-radius: 50%;
            transform: translateY(-50%);
            opacity: 0.5;
        }
        .btn-add-cart {
            display: inline-block;
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 3px;
            color: var(--text-dark);
            text-decoration: none;
            padding-bottom: 5px;
            border-bottom: 2px solid var(--primary-light);
            transition: all 0.3s;
        }
        .btn-add-cart:hover {
            color: var(--primary);
            border-bottom-color: var(--primary);
            letter-spacing: 4px;
        }

        /* Creative Testimonial */
        .testimonial-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 40px;
            margin: 60px 0;
        }
        .testimonial-card {
            background: rgba(255, 255, 255, 0.55);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            padding: 60px 40px 45px;
            text-align: center;
            border-radius: 120px 20px 120px 20px;
            border: 1px solid rgba(255, 255, 255, 0.6);
            transition: all 0.6s cubic-bezier(0.16, 1, 0.3, 1);
            opacity: 0;
            transform: translateY(30px);
            box-shadow: var(--shadow-sm);
        }
        .testimonial-card.animate {
            opacity: 1;
            transform: translateY(0);
        }
        .testimonial-card:hover {
            transform: translateY(-10px) scale(1.02);
            background: rgba(255, 255, 255, 0.9);
            box-shadow: var(--shadow-lg);
            border-color: var(--primary-light);
        }
        .testimonial-card i.fa-quote-left {
            font-size: 35px;
            color: var(--primary);
            opacity: 0.25;
            margin-bottom: 25px;
            display: block;
        }
        .testimonial-card p {
            font-family: 'Cormorant Garamond', serif;
            font-style: italic;
            font-size: 21px;
            line-height: 1.6;
            color: var(--text-dark);
            margin-bottom: 30px;
        }
        .testimonial-card .name {
            font-family: 'DM Sans', sans-serif;
            font-weight: 800;
            font-size: 12px;
            letter-spacing: 3px;
            text-transform: uppercase;
            color: var(--primary-dark);
            display: block;
        }

        /* Artisan FAQ */
        .faq-grid {
            max-width: 850px;
            margin: 40px auto;
        }
        .faq-item {
            background: rgba(255, 255, 255, 0.55);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            margin-bottom: 16px;
            border: 1px solid rgba(255, 255, 255, 0.6);
            border-radius: 18px;
            transition: all 0.4s cubic-bezier(0.16, 1, 0.3, 1);
            overflow: hidden;
            box-shadow: var(--shadow-sm);
        }
        .faq-item:hover {
            border-color: var(--primary-light);
            background: rgba(255, 255, 255, 0.85);
            box-shadow: var(--shadow-md);
        }
        .faq-item.active {
            border-color: var(--primary);
            background: #fff;
            box-shadow: var(--shadow-md);
            transform: translateY(-4px);
        }
        .faq-question {
            padding: 24px 30px;
            font-family: 'Cormorant Garamond', serif;
            font-size: 21px;
            font-weight: 600;
            color: var(--text-dark);
            cursor: pointer;
            display: flex;
            justify-content: space-between;
            align-items: center;
            transition: 0.3s;
        }
        .faq-question:hover {
            color: var(--primary);
        }
        .faq-question i {
            font-size: 12px;
            color: var(--primary-light);
            background: rgba(141, 110, 99, 0.05);
            width: 32px;
            height: 32px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.4s;
        }
        .faq-item.active .faq-question i {
            background: var(--primary);
            color: #fff;
            transform: rotate(180deg);
        }
        .faq-answer {
            padding: 0 30px;
            max-height: 0;
            overflow: hidden;
            transition: all 0.5s cubic-bezier(0.16, 1, 0.3, 1);
            color: var(--text-muted);
            font-size: 15px;
            line-height: 1.8;
        }
        .faq-item.active .faq-answer {
            padding-bottom: 30px;
            max-height: 500px;
        }

        /* Brand Hero Section */
        .brand-hero-section {
            background: transparent;
            padding: 100px 0 120px;
            margin-top: 60px;
        }
        .brand-bg-text {
            text-align: center;
            font-family: 'Cormorant Garamond', serif;
            font-size: clamp(48px, 12vw, 180px);
            font-weight: 500;
            color: var(--text-dark);
            letter-spacing: 4px;
            user-select: none;
            line-height: 1;
        }
        .brand-bg-text span {
            font-style: italic;
            font-weight: 600;
            color: var(--text-light);
        }

        /* Reveal animation */
        .reveal {
            opacity: 0;
            transform: translateY(35px);
            transition: 1s cubic-bezier(0.16, 1, 0.3, 1);
        }
        .reveal.active {
            opacity: 1;
            transform: translateY(0);
        }

        .brand-links-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 40px;
            margin: 120px auto 0;
            max-width: 850px;
            text-align: left;
        }
        .brand-col h5 {
            font-size: 13px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 2px;
            margin-bottom: 25px;
            color: var(--text-dark);
        }
        .brand-col ul { list-style: none; padding: 0; margin: 0; }
        .brand-col ul li { margin-bottom: 15px; }
        .brand-col ul li a {
            font-size: 14px;
            color: var(--text-muted);
            text-decoration: none;
            transition: 0.3s;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .brand-col ul li a:hover { color: var(--primary); transform: translateX(5px); }
        .brand-col ul li a i { font-size: 16px; width: 20px; color: var(--primary); }

        /* Responsive */
        @media (max-width: 1024px) {
            .nc-nav { padding: 20px 40px; }
            .nc-nav-links { gap: 32px; }
            .feature-grid { grid-template-columns: repeat(2, 1fr); gap: 24px; }
            .product-grid, .testimonial-grid { grid-template-columns: repeat(2, 1fr); gap: 30px; }
        }

        /* Mobile Menu Default Hidden */
        .nc-nav-toggle, .nc-mobile-menu, .nc-menu-overlay {
            display: none;
        }

        /* Mobile Menu Styling */
        .nc-nav-toggle {
            flex-direction: column;
            gap: 5px;
            cursor: pointer;
            z-index: 1002;
            padding: 5px;
        }
        .nc-nav-toggle span {
            width: 24px;
            height: 2px;
            background: var(--text-dark);
            transition: 0.3s;
        }

        @media (max-width: 768px) {
            .container { padding: 0 24px; }
            
            /* Navbar Mobile */
            .nc-nav { padding: 20px; }
            .nc-nav-toggle { display: flex; }
            .nc-menu-overlay { display: block; }
            
            .nc-nav-links, .header-actions {
                display: none; /* Hide standard nav */
            }

            .nc-mobile-menu {
                display: flex;
                position: fixed;
                top: 0;
                right: -100%;
                width: 80%;
                max-width: 320px;
                height: 100vh;
                background: var(--bg-white);
                z-index: 1001;
                padding: 100px 40px;
                display: flex;
                flex-direction: column;
                gap: 40px;
                box-shadow: -10px 0 30px rgba(0,0,0,0.05);
                transition: 0.5s cubic-bezier(0.4, 0, 0.2, 1);
            }

            .nc-mobile-menu.active {
                right: 0;
            }

            .nc-mobile-menu ul {
                list-style: none;
                padding: 0;
                display: flex;
                flex-direction: column;
                gap: 25px;
            }

            .nc-mobile-menu ul li a {
                font-size: 16px;
                letter-spacing: 2px;
                text-transform: uppercase;
                color: var(--text-dark);
                text-decoration: none;
                font-weight: 500;
                display: block;
            }

            .nc-mobile-actions {
                display: flex;
                flex-direction: column;
                gap: 20px;
                padding-top: 30px;
                border-top: 1px solid var(--border);
            }

            /* Overlay */
            .nc-menu-overlay {
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                height: 100vh;
                background: rgba(0,0,0,0.3);
                z-index: 1000;
                opacity: 0;
                visibility: hidden;
                transition: 0.3s;
                backdrop-filter: blur(2px);
            }
            .nc-menu-overlay.active {
                opacity: 1;
                visibility: visible;
            }

            /* Hamburger Animation */
            .nc-nav-toggle.active span:nth-child(1) { transform: translateY(7px) rotate(45deg); }
            .nc-nav-toggle.active span:nth-child(2) { opacity: 0; }
            .nc-nav-toggle.active span:nth-child(3) { transform: translateY(-7px) rotate(-45deg); }

            /* Hero & Sections */
            .hero-section { padding: 160px 20px 80px; }
            .hero-title { font-size: 48px; }
            .hero-desc { font-size: 14px; margin-bottom: 35px; }
            
            .feature-grid { grid-template-columns: 1fr; max-width: 400px; margin: 0 auto; gap: 20px; }
            .product-grid, .testimonial-grid { grid-template-columns: 1fr; max-width: 400px; margin: 0 auto; }
            
            .section-padding { padding: 60px 0; }
            .section-title { font-size: 28px; margin-bottom: 35px; }

            .brand-hero-section { padding: 60px 0 80px; margin-top: 40px; }
            .brand-bg-text { font-size: 52px; }
            .brand-links-grid {
                grid-template-columns: repeat(2, 1fr);
                gap: 40px 20px;
                margin-top: 60px;
                text-align: center;
            }
            .brand-col h5 { margin-bottom: 15px; font-size: 11px; }
            .brand-col ul li a { justify-content: center; font-size: 13px; }
        }

        @media (max-width: 480px) {
            .hero-btns { flex-direction: column; align-items: stretch; gap: 15px; }
            .btn-nc-dark, .btn-nc-outline { width: 100%; }
            .brand-links-grid { 
                grid-template-columns: repeat(2, 1fr); /* Tetap 2 kolom agar tidak terlalu panjang kebawah */
                gap: 35px 15px;
            }
            .brand-bg-text { font-size: 42px; }
        }
    </style>
    @stack('styles')
</head>
<body>

    <canvas id="waveCanvas"></canvas>

    <!-- HEADER dengan Logo Gambar -->
    <nav class="nc-nav">
        <div class="logo">
            <a href="{{ route('beranda') }}">
                <img src="{{ asset('image/nyonyacrumb.png') }}" alt="Nyonya Crumb">
                <div class="logo-text">
                    <span class="logo-text-main">Nyonya Crumb</span>
                </div>
            </a>
        </div>

        <!-- Hamburger Icon (Mobile) -->
        <div class="nc-nav-toggle" id="navToggle">
            <span></span>
            <span></span>
            <span></span>
        </div>

        <!-- Desktop Menu -->
        <ul class="nc-nav-links">
            <li><a href="{{ route('beranda') }}">Beranda</a></li>
            <li><a href="{{ route('produk.all') }}">Produk</a></li>
            <li><a href="{{ route('cara.pesan') }}">Cara Pesan</a></li>
            <li><a href="{{ route('contact') }}">Kontak</a></li>
        </ul>

        <div class="header-actions">
            @php
                $cartCount = 0;
                if(Auth::check()) {
                    $customer = \App\Models\Customer::where('user_id', Auth::id())->first();
                    if ($customer) {
                        $order = \App\Models\Order::where('customer_id', $customer->id)->where('status', 'pending')->first();
                        if ($order) $cartCount = $order->orderItems()->sum('quantity');
                    }
                }
            @endphp
            <a href="{{ route('v_order.cart') }}" class="nc-action-link">Keranjang ({{ $cartCount }})</a>

            @if (Auth::check())
            @php
                $userFoto = Auth::user()->foto ? asset('storage/img-customer/' . Auth::user()->foto) : asset('storage/img-user/img-default.jpg');
            @endphp
            <div class="nc-dropdown" id="profileDropdown">
                <a href="#" id="profileDropdownTrigger" class="nc-action-link nc-dropdown-trigger" style="display: inline-flex; align-items: center; justify-content: center; width: 36px; height: 36px; border-radius: 50%; overflow: hidden; border: 2px solid rgba(93,64,55,0.25); transition: all 0.3s;" aria-expanded="false">
                    <img src="{{ $userFoto }}" alt="Profil" style="width: 100%; height: 100%; object-fit: cover; border-radius: 50%;">
                </a>
                <div class="nc-dropdown-menu" id="profileDropdownMenu">
                    @if(in_array(Auth::user()->role, ['0', '1']))
                        {{-- Menu khusus Admin/Superadmin saat di Beranda --}}
                        <a href="{{ route('backend.beranda') }}"><i class="fa fa-dashboard" style="width: 20px;"></i> Dashboard Admin</a>
                        <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><i class="fa fa-sign-out" style="width: 20px;"></i> Keluar</a>
                    @else
                        {{-- Menu khusus Customer --}}
                        <a href="{{ route('customer.akun', ['id' => Auth::user()->id]) }}"><i class="fa fa-user-o" style="width: 20px;"></i> Profil Saya</a>
                        <a href="{{ route('order.history') }}"><i class="fa fa-shopping-bag" style="width: 20px;"></i> Riwayat</a>
                        <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><i class="fa fa-sign-out" style="width: 20px;"></i> Keluar</a>
                    @endif
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">@csrf</form>
                </div>
            </div>

            @else
            <a href="{{ route('auth.login') }}" class="nc-action-link">Masuk</a>
            @endif
        </div>
    </nav>

    <!-- Mobile Drawer & Overlay -->
    <div class="nc-menu-overlay" id="menuOverlay"></div>
    <div class="nc-mobile-menu" id="mobileMenu">
        <ul>
            <li><a href="{{ route('beranda') }}">Beranda</a></li>
            <li><a href="{{ route('produk.all') }}">Produk</a></li>
            <li><a href="{{ route('cara.pesan') }}">Cara Pesan</a></li>
            <li><a href="{{ route('contact') }}">Kontak</a></li>
        </ul>
        <div class="nc-mobile-actions">
            <a href="{{ route('v_order.cart') }}" class="nc-action-link">Keranjang ({{ $cartCount }})</a>
            @if (Auth::check())
                @if(in_array(Auth::user()->role, ['0', '1']))
                    <a href="{{ route('backend.beranda') }}" class="nc-action-link">Dashboard Admin</a>
                @else
                    <a href="{{ route('customer.akun', ['id' => Auth::user()->id]) }}" class="nc-action-link">Profil Saya</a>
                    <a href="{{ route('order.history') }}" class="nc-action-link">Riwayat Pesanan</a>
                @endif
                <a href="#" class="nc-action-link" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Keluar</a>
            @else
                <a href="{{ route('auth.login') }}" class="nc-action-link">Masuk</a>
            @endif
        </div>
    </div>

    @yield('content')

    @if(request()->routeIs('beranda') || request()->is('/'))
    <!-- HERO SECTION -->
    <section class="hero-section">
        <div class="container">
            <div class="text-center" style="max-width: 800px; margin: 0 auto; position: relative; z-index: 2;">
                <div class="hero-eyebrow justify-content-center" style="margin-bottom: 24px;">
                    <div class="line"></div>
                    <span>Homemade • Nyonya • Crumb</span>
                    <div class="line"></div>
                </div>

                <h1 class="hero-title text-center" style="margin-bottom: 24px;">Every Bite <br><span>Matters</span>.</h1>

                <p class="hero-desc text-center" style="max-width: 600px; margin: 0 auto 40px;">
                    Nyonya Crumb menghadirkan cookies homemade dengan cita rasa autentik, bahan berkualitas pilihan, dan sentuhan kehangatan dalam setiap sajian  karena Every Bite Matters.
                </p>

                <div class="hero-btns justify-content-center">
                    <a href="{{ route('produk.all') }}" class="btn-nc-dark">Belanja Sekarang →</a>
                </div>
            </div>
        </div>
    </section>

    <!-- SECTION TENTANG KAMI -->
    <section class="about-section section-padding reveal" style="background: transparent; border-top: 1px solid var(--border); border-bottom: 1px solid var(--border); position: relative; overflow: hidden;">
        <div class="container">
            <!-- Centered Header Above -->
            <div class="text-center" style="margin-bottom: 60px;">
                <h2 class="section-title" style="margin-bottom: 15px; color: var(--text-dark);">Tentang Kami</h2>
                <p style="color: var(--text-muted); font-size: 14.5px; max-width: 600px; margin: 0 auto; line-height: 1.6;">Perjalanan menghadirkan cookies homemade dengan kualitas terbaik dan rasa yang berkesan.</p>
            </div>

            <div class="row align-items-center g-5">
                <!-- Left: Content -->
                <div class="col-md-6 text-start">
                    <div style="display: inline-flex; align-items: center; gap: 8px; color: var(--primary); font-size: 11px; font-weight: 600; letter-spacing: 2px; text-transform: uppercase; margin-bottom: 15px;">
                        <span style="width: 20px; height: 1px; background: var(--primary); display: inline-block;"></span>
                        Tentang Kami
                    </div>

                    <p style="font-size: 15px; line-height: 1.8; color: var(--text-dark); margin-bottom: 20px; font-weight: 500; text-align: justify;">
                        <strong>Tidak hanya sekadar toko cookies rumahan biasa,</strong> Nyonya Crumb hadir sebagai wujud dari hangatnya cita rasa homemade yang dibuat dengan perhatian pada kualitas dan detail di setiap adonan. Berawal dari kecintaan terhadap dunia baking, kami menghadirkan cookies yang diproduksi fresh menggunakan bahan-bahan pilihan untuk menghasilkan rasa, tekstur, dan aroma yang istimewa dalam setiap gigitan.
                    </p>
                    <p style="font-size: 14.5px; line-height: 1.8; color: var(--text-muted); margin-bottom: 20px; text-align: justify;">
                        Kami percaya bahwa cookies bukan hanya sekadar camilan, tetapi juga bagian dari momen berharga yang dapat dinikmati bersama keluarga, sahabat, dan orang terdekat. Dengan mengutamakan kualitas, konsistensi, dan kehangatan khas rumahan, Nyonya Crumb berkomitmen menghadirkan cookies yang tidak hanya lezat, tetapi juga menciptakan kenangan manis dalam setiap remahnya.
                    </p>
                    <p style="font-size: 15px; font-style: italic; color: var(--primary); font-weight: 600; margin-bottom: 30px; border-left: 2px solid var(--primary-light); padding-left: 15px; line-height: 1.7; text-align: justify;">
                        Nyonya Crumb — Karena setiap remah menyimpan cerita, dan setiap cookies dibuat untuk menciptakan kenangan.
                    </p>
                    <!-- Visi Misi -->
                    <div class="row g-4" style="border-top: 1px solid var(--border); padding-top: 25px;">
                        <div class="col-sm-6">
                            <h5 style="font-family: 'DM Sans', sans-serif; font-weight: 700; font-size: 14px; letter-spacing: 0.5px; color: var(--text-dark); margin-bottom: 12px; display: flex; align-items: center; gap: 8px;">
                                <i class="fa fa-compass" style="color: var(--primary);"></i> Visi
                            </h5>
                            <p style="font-size: 13px; color: var(--text-muted); line-height: 1.6; margin: 0; text-align: justify;">Menjadi brand cookies rumahan yang dikenal karena kualitas produk, cita rasa yang konsisten, dan pelayanan yang terpercaya.</p>
                        </div>
                        <div class="col-sm-6">
                            <h5 style="font-family: 'DM Sans', sans-serif; font-weight: 700; font-size: 14px; letter-spacing: 0.5px; color: var(--text-dark); margin-bottom: 12px; display: flex; align-items: center; gap: 8px;">
                                <i class="fa fa-bullseye" style="color: var(--primary);"></i> Misi
                            </h5>
                            <p style="font-size: 13px; color: var(--text-muted); line-height: 1.6; margin: 0; text-align: justify;">Menghasilkan cookies berkualitas dengan bahan baku pilihan, menjaga standar kebersihan dan kualitas dalam setiap proses produksi, memberikan pelayanan yang responsif dan berorientasi pada kepuasan pelanggan, serta mengembangkan variasi produk yang sesuai dengan kebutuhan dan selera konsumen.</p>
                        </div>
                    </div>  </div>
                <!-- Right: Image Frame -->
                <div class="col-md-6">
                    <div style="position: relative;">
                        <!-- Main Image Container -->
                        <div class="about-img-container">
                            <img src="{{ asset('image/about_cookies.png') }}" alt="Baking Premium Cookies">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- PRODUK UNGGULAN -->
    @php
        $produkTerlaris = App\Models\Produk::with('kategori')
            ->where('status', 1)
            ->orderBy('created_at', 'desc')
            ->get();

        if (!function_exists('getBahanDetail')) {
            function getBahanDetail($bahanName) {
                $name = trim($bahanName);
                $name_lower = strtolower($name);
                
                $details = [
                    'tepung' => [
                        'title' => 'Tepung Terigu',
                        'desc' => 'Tepung terigu berkualitas untuk menghasilkan tekstur cookies yang sempurna.',
                        'img' => asset('image/tepung_terigu.png')
                    ],
                    'mentega' => [
                        'title' => 'Mentega ',
                        'desc' => 'Mentega berkualitas menjadi salah satu kunci terciptanya cookies dengan rasa yang lezat dan aroma yang khas.',
                        'img' => 'https://images.unsplash.com/photo-1589985270826-4b7bb135bc9d?auto=format&fit=crop&w=150&q=80'
                    ],
                    'gula' => [
                        'title' => 'Pemanis',
                        'desc' => 'Kombinasi brown sugar dan pemanis pilihan untuk cita rasa lebih seimbang yang menjadi ciri khas di setiap cookies Nyonya Crumb.',
                        'img' => asset('image/brown_sugar.png')
                    ],
                    'cokelat' => [
                        'title' => 'Cokelat Belgian',
                        'desc' => 'Cokelat premium yang lumer lembut memanjakan lidah di setiap gigitan.',
                        'img' => 'https://images.unsplash.com/photo-1548907040-4d42b52145ca?auto=format&fit=crop&w=150&q=80'
                    ],
                    'choco' => [
                        'title' => 'Choco Chips',
                        'desc' => 'Butiran cokelat chips melimpah yang manis dan lumer merata.',
                        'img' => 'https://images.unsplash.com/photo-1548907040-4d42b52145ca?auto=format&fit=crop&w=150&q=80'
                    ],
                    'matcha' => [
                        'title' => 'Uji Matcha',
                        'desc' => 'Teh hijau Jepang murni kaya antioksidan dan wangi autentik.',
                        'img' => 'https://images.unsplash.com/photo-1536256263959-770b48d82b0a?auto=format&fit=crop&w=150&q=80'
                    ],
                    'oat' => [
                        'title' => 'Oat Gandum',
                        'desc' => 'Gandum utuh berserat tinggi untuk mendukung kesehatan pencernaan.',
                        'img' => 'https://images.unsplash.com/photo-1586444248902-2f64eddc13df?auto=format&fit=crop&w=150&q=80'
                    ],
                    'almond' => [
                        'title' => 'Kacang Almond',
                        'desc' => 'Kepingan almond renyah kaya vitamin E dan lemak baik.',
                        'img' => 'https://images.unsplash.com/photo-1508061253366-f7da158b6d46?auto=format&fit=crop&w=150&q=80'
                    ],
                    'biscoff' => [
                        'title' => 'Lotus Biscoff',
                        'desc' => 'Kombinasi biskuit karamel Lotus Biscoff manis beraroma rempah.',
                        'img' => 'https://images.unsplash.com/photo-1590080875515-8a3a8dc5735e?auto=format&fit=crop&w=150&q=80'
                    ],
                    'red' => [
                        'title' => 'Red Velvet',
                        'desc' => 'Sentuhan kelembutan vanila dan cokelat ringan khas red velvet.',
                        'img' => 'https://images.unsplash.com/photo-1616031037011-087000171abe?auto=format&fit=crop&w=150&q=80'
                    ],
                    'keju' => [
                        'title' => 'Keju Cheddar',
                        'desc' => 'Keju cheddar gurih asin yang meleleh sempurna saat dipanggang.',
                        'img' => 'https://images.unsplash.com/photo-1486887396153-fa416525c108?auto=format&fit=crop&w=150&q=80'
                    ],
                    'telur' => [
                        'title' => 'Telur Segar',
                        'desc' => 'Telur ayam segar berkualitas tinggi sebagai pengikat alami adonan.',
                        'img' => 'https://images.unsplash.com/photo-1582722472251-8926cc73ca72?auto=format&fit=crop&w=150&q=80'
                    ],
                    'susu' => [
                        'title' => 'Susu Murni',
                        'desc' => 'Susu cair segar menambah rasa gurih creamy yang nikmat.',
                        'img' => 'https://images.unsplash.com/photo-1550583724-b2692b85b150?auto=format&fit=crop&w=150&q=80'
                    ],
                ];

                foreach ($details as $key => $value) {
                    if (strpos($name_lower, $key) !== false) {
                        return $value;
                    }
                }

                return [
                    'title' => $name,
                    'desc' => 'Bahan pilihan berkualitas tinggi diproses secara higienis.',
                    'img' => 'https://images.unsplash.com/photo-1495521821757-a1efb6729352?auto=format&fit=crop&w=150&q=80'
                ];
            }
        }
    @endphp

    <section class="hotto-showcase reveal">
        <div class="container">
            <!-- Header section -->
            <div class="text-center" style="margin-bottom: 50px; position: relative; z-index: 2;">
                <h2 class="section-title" style="margin-bottom: 15px; color: var(--text-dark);">Produk Kami</h2>
                <p style="color: var(--text-muted); font-size: 14.5px; max-width: 600px; margin: 0 auto; line-height: 1.6;">Nikmati kelezatan rasa dan aroma harum panggangan segar dari deretan cookies terlaris kami.</p>
            </div>

            <div class="product-tabs-wrapper">
                @foreach($produkTerlaris as $index => $prod)
                    <button class="product-tab-btn {{ $index === 0 ? 'active' : '' }}" onclick="switchProductTab({{ $index }})">
                        {{ $prod->nama_produk }}
                    </button>
                @endforeach
            </div>

            <!-- Tab Content Loop -->
            @forelse($produkTerlaris as $index => $prod)
                <div class="hotto-product-tab-content {{ $index === 0 ? 'active' : '' }}" id="hotto-tab-content-{{ $index }}">
                    <div class="hotto-grid">
                        <!-- Left Info -->
                        <div class="hotto-left">
                            <div class="hotto-eyebrow">
                                <i class="fa fa-star"></i> PRODUCT OF NYONYA CRUMB
                            </div>
                            <h2 class="hotto-title">{{ $prod->nama_produk }}</h2>
                            <p class="hotto-desc">
                                @if(trim($prod->detail) !== '')
                                    {!! Str::limit(strip_tags($prod->detail), 260) !!}
                                @else
                                    Kue kering homemade dari Nyonya Crumb dipanggang segar dengan cita rasa autentik dan bahan berkualitas. Pilihan terbaik untuk menemani momen berharga Anda bersama keluarga tercinta.
                                @endif
                            </p>
                            <div>
                                <a href="{{ route('produk.detail', $prod->id) }}" class="hotto-btn-detail">
                                    Lihat Detail Produk <i class="fa fa-chevron-right" style="font-size: 10px;"></i>
                                </a>
                            </div>
                        </div>

                        <!-- Right Image -->
                        <div class="hotto-right-img">
                            @php
                                $fotoUrl = asset('frontend/images/default-product.jpg');
                                if($prod->foto) {
                                    $fotoUrl = asset('storage/img-produk/' . $prod->foto);
                                } elseif($prod->fotoProduk->first()) {
                                    $fotoUrl = asset('storage/img-produk/' . $prod->fotoProduk->first()->foto);
                                }
                            @endphp
                            <img src="{{ $fotoUrl }}" alt="{{ $prod->nama_produk }}">
                        </div>
                    </div>

                    <!-- Key Ingredients Divider -->
                    <div class="hotto-divider">
                        <span class="hotto-divider-text">KEY INGREDIENTS</span>
                    </div>

                    <!-- Ingredients Row -->
                    <div class="hotto-ingredients-grid">
                        @php
                            $bahanArray = explode(',', $prod->bahan ?? 'Tepung,Mentega,Gula');
                        @endphp
                        @foreach(array_slice($bahanArray, 0, 4) as $bahan)
                            @php
                                $detail = getBahanDetail($bahan);
                            @endphp
                            <div class="hotto-ingredient-card" style="animation-delay: {{ $loop->index * 0.1 }}s;">
                                <div class="hotto-ingredient-circle">
                                    <img src="{{ $detail['img'] }}" alt="{{ $bahan }}">
                                </div>
                                <h4>{{ $detail['title'] }}</h4>
                                <p>{{ $detail['desc'] }}</p>
                            </div>
                        @endforeach
                    </div>
                </div>
            @empty
                <div class="text-center py-5">
                    <p style="color: var(--text-muted);">Belum ada produk terlaris tersedia saat ini.</p>
                </div>
            @endforelse
        </div>
    </section>

    <!-- Tab Switcher Script -->
    <script>
        function switchProductTab(index) {
            // Remove active class from all tab buttons
            document.querySelectorAll('.product-tab-btn').forEach(btn => {
                btn.classList.remove('active');
            });
            // Add active class to the clicked tab button
            document.querySelectorAll('.product-tab-btn')[index].classList.add('active');
            
            // Hide all tab contents
            document.querySelectorAll('.hotto-product-tab-content').forEach(content => {
                content.classList.remove('active');
            });
            // Show selected tab content
            document.getElementById('hotto-tab-content-' + index).classList.add('active');
        }
    </script>

    <!-- TESTIMONI -->
    <section class="testimonial-section section-padding reveal">
        <div class="container">
            <h2 class="section-title">Apa Kata <span>Pelanggan</span></h2>
            <div class="testimonial-grid">
                @php
                    $latestReviews = \App\Models\Review::with('user', 'produk')->orderBy('created_at', 'desc')->take(3)->get();
                @endphp

                @forelse($latestReviews as $index => $review)
                    <div class="testimonial-card">
                        <i class="fa fa-quote-left"></i>
                        <div style="color: #D4A373; font-size: 13px; margin-bottom: 10px;">
                            @for($i=1; $i<=5; $i++)
                                @if($i <= $review->rating) <i class="fa fa-star"></i> @else <i class="fa fa-star-o"></i> @endif
                            @endfor
                        </div>
                        <p>"{{ Str::limit($review->comment, 110) }}"</p>
                        <div class="name">— {{ $review->user->nama ?? 'Anonim' }}</div>
                        <div style="font-size: 11px; color: var(--text-light); margin-top: 6px;">{{ $review->produk->nama_produk ?? 'Produk' }}</div>
                    </div>
                @empty
                    <div class="testimonial-card">
                        <i class="fa fa-quote-left"></i>
                        <p>"Kue kering Nyonya Crumb selalu menjadi pilihan utama keluarga kami karena rasanya yang lezat dan kualitasnya yang terjamin."</p>
                        <div class="name">— Pelanggan Setia</div>
                    </div>
                @endforelse
            </div>
        </div>
    </section>

    <!-- FAQ -->
    <section class="faq-section section-padding reveal">
        <div class="container">
            <h2 class="section-title">Pertanyaan yang <span>Sering Diajukan</span></h2>
            <div class="faq-grid">
                <div class="faq-item">
                    <div class="faq-question">Apakah cookies ini menggunakan bahan pengawet? <i class="fa fa-chevron-down"></i></div>
                    <div class="faq-answer">Tidak, semua cookies Nyonya Crumb dibuat tanpa pengawet buatan. Kami menggunakan bahan alami dan diproduksi secara homemade.</div>
                </div>
                <div class="faq-item">
                    <div class="faq-question">Berapa lama masa simpan cookies? <i class="fa fa-chevron-down"></i></div>
                    <div class="faq-answer">Disarankan dikonsumsi dalam 2 minggu dalam kemasan tertutup rapat. Untuk menjaga kerenyahan, simpan di wadah kedap udara.</div>
                </div>
                <div class="faq-item">
                    <div class="faq-question">Apakah bisa request cookies untuk acara spesial? <i class="fa fa-chevron-down"></i></div>
                    <div class="faq-answer">Tentu, kami menerima pesanan custom untuk pernikahan, ulang tahun, atau hampers. Hubungi customer service kami.</div>
                </div>
                <div class="faq-item">
                    <div class="faq-question">Bagaimana cara pemesanan dan pembayaran? <i class="fa fa-chevron-down"></i></div>
                    <div class="faq-answer">Anda bisa pesan langsung melalui website, pilih produk, lalu checkout. Pembayaran via transfer bank, e-wallet, atau COD wilayah tertentu.</div>
                </div>
            </div>
        </div>
    </section>

    <!-- BRAND HERO SECTION (footer links replaced) -->
    <section class="brand-hero-section reveal">
        <div class="container">
            <div class="brand-bg-text">Nyonya <span>Crumb</span></div>
            
            <div class="brand-links-grid">
                <div class="brand-col">
                    <h5>Explore</h5>
                    <ul>
                        <li><a href="{{ route('produk.all') }}">Semua Produk</a></li>
                    </ul>
                </div>
                <div class="brand-col">
                    <h5>How to Order</h5>
                    <ul>
                        <li><a href="{{ route('cara.pesan') }}">Cara Pesan</a></li>
                    </ul>
                </div>
                <div class="brand-col">
                    <h5>About</h5>
                    <ul>
                        <li><a href="#">Tentang Kami</a></li>
                        <li><a href="{{ route('contact') }}">Kontak</a></li>
                    </ul>
                </div>
                <div class="brand-col">
                    <h5>Follow</h5>
                    <ul>
                        <li><a href="https://www.instagram.com/nyonya.crumb?igsh=MTg1NDFvcjYzb2J3ag=="><i class="fa fa-instagram"></i> Instagram</a></li>
                        <li><a href="https://web.whatsapp.com/"><i class="fa fa-whatsapp"></i> WhatsApp</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </section>
    @endif

    <!-- JS SCRIPTS -->
    <script src="{{ asset('frontend/js/jquery.min.js') }}"></script>
    <script src="{{ asset('frontend/js/bootstrap.min.js') }}"></script>
    <script>
        $(document).ready(function(){
            // Sticky Navbar on Scroll
            function handleNavbarScroll() {
                const nav = document.querySelector('.nc-nav');
                if (nav) {
                    if (window.scrollY > 40) {
                        nav.classList.add('scrolled');
                    } else {
                        nav.classList.remove('scrolled');
                    }
                }
            }
            handleNavbarScroll();
            window.addEventListener('scroll', handleNavbarScroll);

            // FAQ toggles
            $('.faq-question').click(function(){
                $(this).parent().toggleClass('active');
                $(this).find('i').toggleClass('fa-chevron-down fa-chevron-up');
            });

            // reveal on scroll
            function isElementInView(el) {
                const rect = el.getBoundingClientRect();
                return (rect.top <= window.innerHeight - 80);
            }
            function handleReveal() {
                $('.reveal').each(function(){
                    if(isElementInView(this) && !$(this).hasClass('active')) {
                        $(this).addClass('active');
                    }
                });
                $('.product-card, .testimonial-card').each(function(){
                    if(isElementInView(this) && !$(this).hasClass('animate')) {
                        $(this).addClass('animate');
                    }
                });
            }
            handleReveal();
            $(window).on('scroll', handleReveal);

            // Wave organic animation (Subtle fullscreen/overall flowing waves)
            const canvas = document.getElementById('waveCanvas');
            if (canvas) {
                const ctx = canvas.getContext('2d');
                let t = 0;
                let w, h;
                function resizeCanvas() {
                    w = canvas.width = window.innerWidth;
                    h = canvas.height = window.innerHeight;
                }
                resizeCanvas();
                window.addEventListener('resize', resizeCanvas);
                function drawWaves() {
                    if (!ctx) return;
                    if (w > 0 && h > 0) {
                        ctx.clearRect(0, 0, w, h);
                        
                        // Solid warm organic color with soft opacity for fullscreen look
                        ctx.strokeStyle = 'rgba(171, 138, 114, 0.14)';
                        const lines = 12; // 12 lines for a beautiful organic background grid
                        for (let i = 0; i < lines; i++) {
                            const progress = i / lines;
                            ctx.lineWidth = 1.0 - (progress * 0.4);
                            ctx.beginPath();
                            let started = false;
                            for (let step = 0; step <= 150; step++) {
                                const px = (step / 150) * w;
                                
                                // Clean, natural wave motion across the entire screen width
                                const waveA = Math.sin(progress * Math.PI * 1.8 + t * 0.2 + step * 0.04) * (25 + progress * 25);
                                const waveB = Math.cos(progress * Math.PI * 1.0 + t * 0.3 - step * 0.03) * (15 + progress * 15);
                                const py = (0.1 * h + progress * 0.8 * h) + (waveA + waveB);
                                
                                if (!started) { ctx.moveTo(px, py); started = true; }
                                else { ctx.lineTo(px, py); }
                            }
                            ctx.stroke();
                        }
                        t += 0.005;
                    }
                    requestAnimationFrame(drawWaves);
                }
                drawWaves();
            }
            // Feature icon click rotation
            document.querySelectorAll('.feature-card').forEach(card => {
                card.addEventListener('click', function() {
                    const icon = this.querySelector('.feature-icon');
                    if (icon) {
                        icon.classList.remove('rotate-animation');
                        void icon.offsetWidth; // trigger reflow to restart animation
                        icon.classList.add('rotate-animation');
                    }
                });
            });

            // Mobile Menu Logic
            const navToggle = document.getElementById('navToggle');
            const mobileMenu = document.getElementById('mobileMenu');
            const menuOverlay = document.getElementById('menuOverlay');

            if (navToggle) {
                navToggle.addEventListener('click', function() {
                    this.classList.toggle('active');
                    mobileMenu.classList.toggle('active');
                    menuOverlay.classList.toggle('active');
                    document.body.style.overflow = mobileMenu.classList.contains('active') ? 'hidden' : '';
                });
            }

            if (menuOverlay) {
                menuOverlay.addEventListener('click', function() {
                    navToggle.classList.remove('active');
                    mobileMenu.classList.remove('active');
                    this.classList.remove('active');
                    document.body.style.overflow = '';
                });
            }
        });
    </script>
    
    {{-- Profile Dropdown click-based --}}
    <script>
        (function() {
            var trigger  = document.getElementById('profileDropdownTrigger');
            var dropdown = document.getElementById('profileDropdown');
            var chevron  = document.getElementById('profileChevron');
            if (!trigger || !dropdown) return;
            trigger.addEventListener('click', function(e) {
                e.preventDefault();
                e.stopPropagation();
                var isOpen = dropdown.classList.toggle('open');
                trigger.setAttribute('aria-expanded', String(isOpen));
                if (chevron) chevron.style.transform = isOpen ? 'rotate(180deg)' : 'rotate(0deg)';
            });
            document.addEventListener('click', function(e) {
                if (!dropdown.contains(e.target)) {
                    dropdown.classList.remove('open');
                    trigger.setAttribute('aria-expanded', 'false');
                    if (chevron) chevron.style.transform = 'rotate(0deg)';
                }
            });
            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape') {
                    dropdown.classList.remove('open');
                    trigger.setAttribute('aria-expanded', 'false');
                    if (chevron) chevron.style.transform = 'rotate(0deg)';
                }
            });
        })();
    </script>
    @yield('scripts')
</body>
</html>