<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('image/nyonyacrumb.png') }}">
    <title> Nyonya Crumb - Premium Cookies</title>

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
            --bg-creme: #FDF9F5;
            --bg-white: #FFFFFF;
            --text-dark: #3E2723;
            --text-muted: #8D6E63;
            --text-light: #C6A68A;
            --border: rgba(139, 94, 60, 0.12);
            --shadow-sm: 0 8px 20px rgba(0,0,0,0.02), 0 2px 6px rgba(0,0,0,0.03);
            --shadow-md: 0 20px 35px -12px rgba(0,0,0,0.08);
            --radius-sm: 2px;
            --radius-md: 8px;
        }

        body {
            background: var(--bg-creme);
            font-family: 'DM Sans', sans-serif;
            color: var(--text-dark);
            overflow-x: hidden;
            line-height: 1.5;
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
            opacity: 0.1;
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
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            z-index: 1000;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 24px 80px 24px 32px;
            background: transparent;
            flex-wrap: wrap;
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
            justify-content: center;
            padding: 140px 20px 100px;
            position: relative;
            text-align: center;
        }

        .hero-eyebrow {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 16px;
            margin-bottom: 32px;
            opacity: 0.7;
        }
        .hero-eyebrow .line {
            width: 35px;
            height: 1px;
            background: var(--text-dark);
        }
        .hero-eyebrow span {
            font-size: 10px;
            letter-spacing: 4px;
            text-transform: uppercase;
            font-weight: 500;
        }

        .hero-title {
            font-family: 'Cormorant Garamond', serif;
            font-size: clamp(58px, 9vw, 110px);
            line-height: 1;
            margin-bottom: 32px;
            color: var(--text-dark);
            font-weight: 400;
        }
        .hero-title span { color: var(--text-light); font-style: italic; }

        .hero-desc {
            font-size: 16px;
            line-height: 1.7;
            color: var(--text-muted);
            max-width: 560px;
            margin: 0 auto 48px;
            font-weight: 400;
        }

        .hero-btns {
            display: flex;
            gap: 20px;
            justify-content: center;
            flex-wrap: wrap;
        }

        .btn-nc-dark {
            background: var(--text-dark);
            color: #fff;
            padding: 16px 40px;
            border-radius: 0;
            font-size: 11px;
            letter-spacing: 2.5px;
            text-transform: uppercase;
            text-decoration: none;
            transition: 0.3s;
            font-weight: 600;
            display: inline-block;
            border: none;
            cursor: pointer;
        }
        .btn-nc-dark:hover {
            background: var(--primary);
            transform: translateY(-2px);
        }

        .btn-nc-outline {
            border: 1px solid rgba(93, 64, 55, 0.3);
            color: var(--text-dark);
            padding: 16px 40px;
            border-radius: 0;
            font-size: 11px;
            letter-spacing: 2.5px;
            text-transform: uppercase;
            text-decoration: none;
            transition: 0.3s;
            font-weight: 600;
            background: transparent;
        }
        .btn-nc-outline:hover {
            border-color: var(--text-dark);
            background: #fff;
            transform: translateY(-2px);
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
            background: #fff;
            padding: 60px 40px 45px;
            text-align: center;
            border-radius: 120px 20px 120px 20px; /* Organic leaf-like shape */
            border: 1px solid #f3efec;
            transition: all 0.6s cubic-bezier(0.165, 0.84, 0.44, 1);
            opacity: 0;
            transform: translateY(30px);
            box-shadow: 0 15px 40px rgba(0,0,0,0.02);
        }
        .testimonial-card.animate {
            opacity: 1;
            transform: translateY(0);
        }
        .testimonial-card:hover {
            transform: translateY(-10px) scale(1.02);
            box-shadow: 0 30px 60px rgba(141, 110, 99, 0.1);
            border-color: var(--primary-light);
        }
        .testimonial-card i.fa-quote-left {
            font-size: 35px;
            color: var(--primary);
            opacity: 0.2;
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
            background: #fff;
            margin-bottom: 16px;
            border: 1px solid #f3efec;
            border-radius: 12px;
            transition: all 0.4s cubic-bezier(0.165, 0.84, 0.44, 1);
            overflow: hidden;
            box-shadow: 0 4px 15px rgba(0,0,0,0.01);
        }
        .faq-item:hover {
            border-color: var(--primary-light);
            box-shadow: 0 10px 25px rgba(141, 110, 99, 0.05);
        }
        .faq-item.active {
            border-color: var(--primary-light);
            background: #fdfbf9;
            box-shadow: 0 15px 35px rgba(141, 110, 99, 0.08);
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
            transition: all 0.5s cubic-bezier(0.165, 0.84, 0.44, 1);
            color: #8a7b73;
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
            transition: 1s cubic-bezier(0.2, 0.9, 0.3, 1.1);
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
            <div class="hero-eyebrow">
                <div class="line"></div>
                <span>Homemade • Nyonya • Crumb</span>
                <div class="line"></div>
            </div>

            <h1 class="hero-title"> Every Bite <br><span> Matters </span>.</h1>

            <p class="hero-desc">
                Nyonya Crumb menghadirkan cookies homemade premium dengan cita rasa autentik, bahan berkualitas pilihan, dan sentuhan kehangatan dalam setiap sajian — karena Every Bite Matters.
            </p>

            <div class="hero-btns">
                <a href="{{ route('produk.all') }}" class="btn-nc-dark">Belanja Sekarang →</a>
                <a href="{{ route('produk.all') }}" class="btn-nc-outline">Lihat Koleksi</a>
            </div>
        </div>
    </section>

    <!-- SECTION FITUR -->
    <section class="feature-section section-padding reveal">
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
    <section class="product-showcase section-padding reveal">
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
                        <a href="{{ route('produk.detail', $produk->id) }}" class="btn-add-cart">Lihat Detail</a>
                    </div>
                </div>
                @empty
                <div class="col-12 text-center"><p>Belum ada produk tersedia.</p></div>
                @endforelse
            </div>
        </div>
    </section>

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
                        <p>"Kue kering Nyonya Crumb selalu menjadi pilihan utama keluarga kami karena rasanya yang premium."</p>
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
                        <li><a href="#">Cerita Kami</a></li>
                        <li><a href="{{ route('contact') }}">Kontak</a></li>
                    </ul>
                </div>
                <div class="brand-col">
                    <h5>Follow</h5>
                    <ul>
                        <li><a href="#"><i class="fa fa-instagram"></i> Instagram</a></li>
                        <li><a href="#"><i class="fa fa-facebook"></i> Facebook</a></li>
                        <li><a href="#"><i class="fa fa-whatsapp"></i> WhatsApp</a></li>
                        <li><a href="#"><i class="fa fa-twitter"></i> Twitter / X</a></li>
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

            // Wave organic animation
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
                    if (!ctx || w === 0 || h === 0) return;
                    ctx.clearRect(0, 0, w, h);
                    ctx.strokeStyle = '#AB8A72';
                    ctx.lineWidth = 0.7;
                    const lines = 32;
                    for (let i = 0; i < lines; i++) {
                        const progress = i / lines;
                        ctx.beginPath();
                        let started = false;
                        for (let step = 0; step <= 130; step++) {
                            const px = (step / 130) * w;
                            const waveA = Math.sin(progress * Math.PI * 2.3 + t * 0.45 + step * 0.06) * 38;
                            const waveB = Math.cos(progress * Math.PI * 1.6 + t * 0.5 + step * 0.045) * 28;
                            const py = (progress * h) + waveA + waveB * (step / 130);
                            if (!started) { ctx.moveTo(px, py); started = true; }
                            else { ctx.lineTo(px, py); }
                        }
                        ctx.stroke();
                    }
                    t += 0.007;
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