<!DOCTYPE html>
<html dir="ltr" lang="id">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
    <meta name="description" content="Admin Panel Nyonya Crumb - Artisan Bakery">

    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('image/nyonyacrumb.png') }}">
    <link rel="shortcut icon" href="{{ asset('image/nyonyacrumb.png') }}">

    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,400;0,600;1,300;1,400&family=DM+Sans:opsz,wght@9..40,300;9..40,400;9..40,500;9..40,600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/remixicon@4.2.0/fonts/remixicon.css">

    <title>Nyonya Crumb · Admin</title>

    <style>
        *, *::before, *::after {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        :root {
            --brand:          #7a6254;
            --brand-dk:       #5c4738;
            --brand-dkk:      #3e2e23;
            --brand-md:       #9b8171;
            --brand-lt:       #c4b0a4;
            --brand-pale:     #f0e9e4;
            --brand-ghost:    #faf6f3;

            --sidebar-bg:     #ffffff;
            --sidebar-dk:     #f9f9f9;
            --sidebar-border: #ede6e1;
            --sidebar-text:   #7a6e68;
            --sidebar-hover:  #faf6f3;
            --sidebar-active: #f0e9e4;

            --ink:            #1a1108;
            --ink-2:          #3a2f28;
            --ink-3:          #7a6e68;
            --ink-4:          #b0a49e;

            --white:          #ffffff;
            --surface:        #ffffff;
            --surface-2:      #faf6f3;
            --border:         #ede6e1;
            --border-md:      #d9cfc9;

            --emerald:        #0d9488;
            --emerald-bg:     #f0fdf9;
            --amber:          #b45309;
            --amber-bg:       #fffbeb;
            --rose:           #e11d48;
            --rose-bg:        #fff1f2;
            --blue:           #1d4ed8;
            --blue-bg:        #eff6ff;

            --sidebar-w:      260px;
            --sidebar-w-sm:   70px;
            --topbar-h:       64px;

            --r-sm:  6px;
            --r-md:  10px;
            --r-lg:  14px;
            --r-xl:  20px;
            --r-2xl: 28px;

            --sh-xs: 0 1px 2px rgba(43,31,24,0.06);
            --sh-sm: 0 2px 8px rgba(43,31,24,0.08), 0 1px 3px rgba(43,31,24,0.05);
            --sh-md: 0 6px 24px rgba(43,31,24,0.10), 0 2px 8px rgba(43,31,24,0.06);
            --sh-lg: 0 16px 48px rgba(43,31,24,0.12), 0 4px 16px rgba(43,31,24,0.07);
            --sh-brand: 0 4px 20px rgba(122,98,84,0.35);
        }

        html, body {
            height: 100%;
            font-family: 'DM Sans', sans-serif;
            background: var(--white);
            color: var(--ink);
            overflow-x: hidden;
            -webkit-font-smoothing: antialiased;
        }

        /* ────────────────────────────────────────
           SIDEBAR
        ──────────────────────────────────────── */
        .left-sidebar {
            position: fixed;
            top: 0; left: 0;
            width: var(--sidebar-w);
            height: 100vh;
            background: var(--sidebar-bg);
            z-index: 1045;
            display: flex;
            flex-direction: column;
            transition: width 0.3s cubic-bezier(0.4,0,0.2,1);
            overflow: hidden;
        }

        /* grain texture overlay */
        .left-sidebar::after {
            content: '';
            position: absolute;
            inset: 0;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='200' height='200'%3E%3Cfilter id='n'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.9' numOctaves='4' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='200' height='200' filter='url(%23n)' opacity='0.04'/%3E%3C/svg%3E");
            pointer-events: none;
            z-index: 0;
        }

        .left-sidebar > * { position: relative; z-index: 1; }

        /* Brand */
        .sidebar-brand {
            height: var(--topbar-h);
            padding: 0 16px;
            display: flex;
            align-items: center;
            justify-content: flex-start;
            gap: 12px;
            border-bottom: 1px solid var(--sidebar-border);
            flex-shrink: 0;
            text-decoration: none;
        }

        .brand-icon {
            width: 38px; height: 38px;
            background: var(--brand);
            border-radius: var(--r-md);
            display: flex; align-items: center; justify-content: center;
            flex-shrink: 0;
            box-shadow: var(--sh-brand);
            font-size: 1.25rem;
            color: #fff;
        }

        .brand-text .b-name {
            font-family: 'Cormorant Garamond', serif;
            font-size: 1.15rem;
            font-weight: 600;
            color: #fff;
            letter-spacing: 0.2px;
            line-height: 1.1;
        }

        .brand-text .b-sub {
            font-size: 0.60rem;
            font-weight: 500;
            color: var(--sidebar-text);
            letter-spacing: 2.5px;
            text-transform: uppercase;
            margin-top: 2px;
        }

        /* Logo text next to brand image */
        .logo-text {
            display: flex;
            flex-direction: column;
            line-height: 1.1;
        }
        .logo-text-main {
            font-family: 'Cormorant Garamond', serif;
            font-size: 1.15rem;
            font-weight: 700;
            letter-spacing: 1px;
            color: var(--brand-dk);
            transition: color 0.25s ease;
        }
        .sidebar-brand:hover .logo-text-main {
            color: var(--brand);
        }

        /* Scroll area */
        .scroll-sidebar {
            flex: 1;
            overflow-y: auto;
            overflow-x: hidden;
            scrollbar-width: none;
            padding: 12px 0;
        }
        .scroll-sidebar::-webkit-scrollbar { display: none; }

        .sidebar-nav { padding: 0 0 16px; }

        /* Section label */
        .nav-cap {
            font-size: 0.58rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 2px;
            color: var(--ink-4);
            padding: 14px 22px 5px;
            white-space: nowrap;
            overflow: hidden;
        }

        /* Nav items */
        #sidebarnav { list-style: none; padding: 0; }

        .sidebar-item { padding: 1px 10px; }

        .sidebar-link {
            display: flex;
            align-items: center;
            gap: 11px;
            padding: 9px 12px;
            color: var(--sidebar-text);
            font-size: 0.82rem;
            font-weight: 500;
            text-decoration: none;
            border-radius: var(--r-lg);
            transition: all 0.18s ease;
            white-space: nowrap;
        }

        .sidebar-link i {
            font-size: 1.05rem;
            width: 22px;
            flex-shrink: 0;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .sidebar-link:hover {
            background: var(--sidebar-hover);
            color: var(--brand-dk);
        }

        .sidebar-item.selected > .sidebar-link,
        .sidebar-item.active > .sidebar-link {
            background: var(--sidebar-active);
            color: var(--brand-dk);
            font-weight: 600;
        }

        .sidebar-item.selected > .sidebar-link i { color: var(--brand); }

        /* Submenu */
        .collapse {
            display: none;
        }

        .first-level {
            list-style: none;
            padding: 2px 0 4px 14px;
        }

        .first-level .sidebar-item { padding: 1px 4px; }

        .first-level .sidebar-link {
            font-size: 0.78rem;
            padding: 7px 12px;
            color: var(--ink-3);
        }

        .first-level .sidebar-link:hover { color: var(--brand-dk); }

        .first-level .sidebar-link i {
            font-size: 0.4rem;
            width: 14px;
            color: var(--ink-4);
        }

        /* Arrow */
        .has-arrow::after {
            content: "\ea4e";
            font-family: 'remixicon';
            font-size: 0.75rem;
            margin-left: auto;
            color: var(--ink-4);
            transition: transform 0.2s ease;
        }

        .has-arrow[aria-expanded="true"]::after {
            transform: rotate(90deg);
            color: var(--brand);
        }

        /* Divider */
        .nav-div {
            height: 1px;
            background: var(--sidebar-border);
            margin: 6px 16px;
        }

        /* Footer */
        .sidebar-foot {
            padding: 10px 10px 18px;
            border-top: 1px solid var(--sidebar-border);
            flex-shrink: 0;
        }

        .logout-btn {
            display: flex;
            align-items: center;
            gap: 11px;
            padding: 9px 12px;
            color: var(--ink-3);
            font-size: 0.82rem;
            font-weight: 500;
            text-decoration: none;
            border-radius: var(--r-lg);
            transition: all 0.18s ease;
            cursor: pointer;
            background: none;
            border: none;
            width: 100%;
        }

        .logout-btn i { font-size: 1.05rem; width: 22px; text-align: center; }

        .logout-btn:hover {
            background: rgba(225,29,72,0.12);
            color: #fb7185;
        }

        /* ────────────────────────────────────────
           TOPBAR
        ──────────────────────────────────────── */
        .topbar {
            position: fixed;
            top: 0; left: 0;
            width: 100%;
            height: var(--topbar-h);
            padding-left: var(--sidebar-w);
            background: var(--white);
            border-bottom: 1px solid var(--border);
            z-index: 1040;
            transition: padding-left 0.3s cubic-bezier(0.4,0,0.2,1);
            box-shadow: var(--sh-xs);
        }

        body.sb-collapsed .topbar { padding-left: var(--sidebar-w-sm); }

        .topbar-inner {
            height: 100%;
            padding: 0 28px;
            display: flex;
            align-items: center;
            gap: 16px;
        }

        .toggler-btn {
            width: 36px; height: 36px;
            border-radius: var(--r-md);
            background: transparent;
            border: 1px solid var(--border);
            color: var(--ink-3);
            display: flex; align-items: center; justify-content: center;
            font-size: 1.1rem;
            cursor: pointer;
            transition: all 0.18s ease;
            flex-shrink: 0;
        }

        .toggler-btn:hover {
            background: var(--brand-pale);
            border-color: var(--brand-lt);
            color: var(--brand);
        }

        .topbar-right {
            margin-left: auto;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        /* Clock */
        .live-clock {
            font-size: 0.76rem;
            font-weight: 500;
            color: var(--ink-3);
            letter-spacing: 0.3px;
            font-variant-numeric: tabular-nums;
        }

        /* Search box */
        .topbar-search {
            display: flex;
            align-items: center;
            gap: 8px;
            background: var(--surface-2);
            border: 1px solid var(--border);
            border-radius: var(--r-xl);
            padding: 7px 14px;
            font-size: 0.78rem;
            color: var(--ink-4);
            cursor: pointer;
            transition: all 0.18s ease;
        }

        .topbar-search:hover {
            border-color: var(--brand-lt);
            background: var(--brand-ghost);
        }

        /* Notif bell */
        .notif-btn {
            width: 36px; height: 36px;
            border-radius: var(--r-md);
            background: var(--surface-2);
            border: 1px solid var(--border);
            color: var(--ink-3);
            display: flex; align-items: center; justify-content: center;
            font-size: 1rem;
            cursor: pointer;
            transition: all 0.18s ease;
            position: relative;
        }

        .notif-btn:hover { border-color: var(--brand-lt); color: var(--brand); }

        .notif-dot {
            position: absolute;
            top: 6px; right: 6px;
            width: 7px; height: 7px;
            background: var(--rose);
            border-radius: 50%;
            border: 1.5px solid var(--white);
        }

        /* User avatar dropdown */
        .user-menu {
            position: relative;
        }

        .user-btn {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 5px 14px 5px 5px;
            background: var(--brand-ghost);
            border: 1px solid var(--border);
            border-radius: 50px;
            cursor: pointer;
            transition: all 0.18s ease;
            text-decoration: none;
        }

        .user-btn:hover {
            border-color: var(--brand-lt);
            background: var(--brand-pale);
        }

        .user-avatar {
            width: 32px; height: 32px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid var(--border-md);
        }

        .user-info .u-name {
            font-size: 0.78rem;
            font-weight: 600;
            color: var(--ink-2);
            line-height: 1.1;
        }

        .user-info .u-role {
            font-size: 0.60rem;
            color: var(--ink-4);
            font-weight: 500;
            letter-spacing: 0.8px;
            text-transform: uppercase;
        }

        /* Dropdown */
        .user-dropdown {
            position: absolute;
            top: calc(100% + 10px);
            right: 0;
            min-width: 230px;
            background: var(--white);
            border: 1px solid var(--border);
            border-radius: var(--r-xl);
            box-shadow: var(--sh-lg);
            padding: 8px;
            z-index: 9999;
            display: none;
            animation: dropSlide 0.2s ease;
        }

        .user-dropdown.open { display: block; }

        @keyframes dropSlide {
            from { opacity: 0; transform: translateY(8px) scale(0.97); }
            to { opacity: 1; transform: translateY(0) scale(1); }
        }

        .drop-header {
            background: linear-gradient(135deg, var(--brand-ghost), var(--brand-pale));
            border: 1px solid var(--border);
            border-radius: var(--r-lg);
            padding: 14px;
            text-align: center;
            margin-bottom: 6px;
        }

        .drop-header .dh-name { font-size: 0.88rem; font-weight: 700; color: var(--ink); }
        .drop-header .dh-email { font-size: 0.70rem; color: var(--ink-3); margin-top: 2px; }

        .drop-item {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 9px 12px;
            font-size: 0.80rem;
            font-weight: 500;
            color: var(--ink-2);
            text-decoration: none;
            border-radius: var(--r-md);
            transition: all 0.14s ease;
            cursor: pointer;
            border: none;
            background: transparent;
            width: 100%;
        }

        .drop-item i { font-size: 1rem; color: var(--ink-4); width: 18px; }
        .drop-item:hover { background: var(--surface-2); color: var(--ink); }

        .drop-divider { height: 1px; background: var(--border); margin: 4px 0; }

        .drop-item.danger { color: var(--rose); }
        .drop-item.danger i { color: var(--rose); }
        .drop-item.danger:hover { background: var(--rose-bg); }

        /* ────────────────────────────────────────
           PAGE WRAPPER
        ──────────────────────────────────────── */
        .page-wrapper {
            margin-left: var(--sidebar-w);
            padding-top: var(--topbar-h);
            min-height: 100vh;
            transition: margin-left 0.3s cubic-bezier(0.4,0,0.2,1);
        }

        body.sb-collapsed .page-wrapper { margin-left: var(--sidebar-w-sm); }

        .page-inner {
            padding: 32px 32px 56px;
        }

        /* ────────────────────────────────────────
           PAGE HEADER
        ──────────────────────────────────────── */
        .page-header {
            margin-bottom: 32px;
            width: 100%;
            display: block;
            clear: both;
        }

        .breadcrumb {
            display: flex;
            align-items: center;
            gap: 6px;
            list-style: none;
            margin-bottom: 8px;
        }

        .breadcrumb-item {
            font-size: 0.72rem;
            font-weight: 500;
            color: var(--ink-4);
        }

        .breadcrumb-item a {
            color: var(--brand);
            text-decoration: none;
            font-weight: 600;
        }

        .breadcrumb-item a:hover { text-decoration: underline; }

        .breadcrumb-sep { color: var(--ink-4); font-size: 0.7rem; }

        .page-title {
            font-family: 'Cormorant Garamond', serif;
            font-size: 2.2rem;
            font-weight: 400;
            color: var(--ink);
            letter-spacing: -0.3px;
            line-height: 1.15;
        }

        .page-subtitle {
            font-size: 0.82rem;
            color: var(--ink-3);
            margin-top: 6px;
        }

        /* ────────────────────────────────────────
           CARDS
        ──────────────────────────────────────── */
        .card {
            background: var(--white);
            border: 1px solid var(--border);
            border-radius: var(--r-xl);
            box-shadow: 0 2px 12px -5px rgba(0,0,0,0.05);
            overflow: hidden;
            margin-bottom: 24px;
            transition: all 0.3s ease;
        }

        .card:hover {
            box-shadow: 0 12px 30px -10px rgba(122, 98, 84, 0.12);
        }

        .card-header {
            background: transparent;
            border-bottom: 1px solid var(--border-lt);
            padding: 20px 24px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
        }

        .card-header-title {
            font-size: 1.05rem;
            font-weight: 600;
            color: var(--ink);
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .card-body { padding: 24px; }

        /* Dashboard Utilities */
        .product-list { display: flex; flex-direction: column; gap: 18px; }
        .product-item { display: flex; align-items: center; gap: 14px; }
        .product-img { 
            width: 44px; height: 44px; 
            border-radius: var(--r-md); 
            overflow: hidden; 
            background: var(--surface-2); 
            display: flex; align-items: center; justify-content: center;
            flex-shrink: 0;
            border: 1px solid var(--border-lt);
        }
        .product-info { flex: 1; }
        .product-name { font-size: 0.88rem; font-weight: 600; color: var(--ink-2); margin-bottom: 4px; }
        
        .mini-progress { 
            height: 6px; 
            background: var(--surface-2); 
            border-radius: 10px; 
            overflow: hidden; 
        }
        .mini-progress-bar { height: 100%; border-radius: 10px; }
        
        .product-stat { font-size: 0.8rem; font-weight: 700; color: var(--ink-3); text-align: right; min-width: 80px; }

        /* Stat cards */
        .stat-card {
            background: var(--white);
            border: 1px solid var(--border);
            border-radius: var(--r-xl);
            padding: 24px;
            box-shadow: var(--sh-sm);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            display: flex;
            align-items: center;
            gap: 18px;
            overflow: hidden;
        }

        .stat-card:hover {
            box-shadow: 0 12px 24px -10px rgba(122, 98, 84, 0.15);
            transform: translateY(-5px);
            border-color: var(--brand-pale);
        }

        .stat-icon-outer {
            width: 52px; height: 52px;
            border-radius: 14px;
            display: flex; align-items: center; justify-content: center;
            font-size: 1.4rem;
            flex-shrink: 0;
            transition: all 0.3s ease;
        }

        .stat-card:hover .stat-icon-outer {
            transform: scale(1.1) rotate(-8deg);
        }

        .stat-icon-outer.brand { background: var(--brand-pale); color: var(--brand); }
        .stat-icon-outer.emerald { background: var(--emerald-bg); color: var(--emerald); }
        .stat-icon-outer.amber { background: var(--amber-bg); color: #b45309; }
        .stat-icon-outer.rose { background: var(--rose-bg); color: var(--rose); }

        .stat-content {
            flex: 1;
        }

        .stat-val {
            font-family: 'Cormorant Garamond', serif;
            font-size: 1.75rem;
            font-weight: 700;
            color: var(--ink);
            line-height: 1.1;
            margin-bottom: 2px;
        }

        .stat-label {
            font-size: 0.82rem;
            font-weight: 500;
            color: var(--ink-3);
            white-space: nowrap;
        }

        /* Subtle background decoration */
        .stat-card::after {
            content: '';
            position: absolute;
            top: -20px;
            right: -20px;
            width: 80px;
            height: 80px;
            background: currentColor;
            opacity: 0.03;
            border-radius: 50%;
            pointer-events: none;
        }

        .stat-change {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            font-size: 0.72rem;
            font-weight: 600;
            padding: 3px 9px;
            border-radius: 20px;
            margin-top: 10px;
        }

        .stat-change.up { background: var(--emerald-bg); color: var(--emerald); }
        .stat-change.dn { background: var(--rose-bg); color: var(--rose); }

        /* ────────────────────────────────────────
           BUTTONS
        ──────────────────────────────────────── */
        .btn {
            display: inline-flex;
            align-items: center;
            gap: 7px;
            padding: 9px 20px;
            font-size: 0.82rem;
            font-weight: 600;
            border-radius: var(--r-lg);
            border: 1px solid var(--border);
            background: var(--white);
            color: var(--ink-2);
            cursor: pointer;
            text-decoration: none;
            transition: all 0.18s ease;
            box-shadow: var(--sh-xs);
            font-family: 'DM Sans', sans-serif;
        }

        .btn:hover {
            transform: translateY(-1px);
            box-shadow: var(--sh-sm);
        }

        .btn-primary {
            background: var(--brand);
            color: #fff;
            border-color: var(--brand);
            box-shadow: var(--sh-brand);
        }

        .btn-primary:hover {
            background: var(--brand-dk);
            border-color: var(--brand-dk);
            box-shadow: 0 6px 24px rgba(122,98,84,0.40);
        }

        .btn-outline {
            background: transparent;
            border-color: var(--border-md);
        }

        .btn-danger {
            background: var(--rose-bg);
            color: var(--rose);
            border-color: rgba(225,29,72,0.2);
        }

        .btn-success {
            background: var(--emerald-bg);
            color: var(--emerald);
            border-color: rgba(13,148,136,0.2);
        }

        .btn-sm { padding: 6px 14px; font-size: 0.75rem; }

        /* ────────────────────────────────────────
           TABLE
        ──────────────────────────────────────── */
        .table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
            font-size: 0.85rem;
        }

        .table thead th {
            font-size: 0.7rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: var(--ink-4);
            padding: 14px 24px;
            background: #faf9f8;
            border-bottom: 1px solid var(--border-lt);
        }

        .table td {
            padding: 16px 24px;
            vertical-align: middle;
            border-bottom: 1px solid var(--border-lt);
            color: var(--ink-2);
        }

        .table tbody tr:last-child td { border-bottom: none; }

        .table tbody tr:hover td { background: #fdfdfd; }

        /* ────────────────────────────────────────
           BADGES
        ──────────────────────────────────────── */
        .badge {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            font-size: 0.65rem;
            font-weight: 700;
            padding: 4px 10px;
            border-radius: 20px;
            letter-spacing: 0.4px;
            text-transform: uppercase;
        }

        .badge::before { content: ''; width: 5px; height: 5px; border-radius: 50%; background: currentColor; opacity: 0.7; }

        .badge-success { background: var(--emerald-bg); color: var(--emerald); }
        .badge-warning { background: var(--amber-bg); color: var(--amber); }
        .badge-danger  { background: var(--rose-bg); color: var(--rose); }
        .badge-info    { background: var(--blue-bg); color: var(--blue); }
        .badge-default { background: var(--surface-2); color: var(--ink-3); }
        .badge-brand   { background: var(--brand-pale); color: var(--brand-dk); }

        /* ────────────────────────────────────────
           FORMS
        ──────────────────────────────────────── */
        .form-control, .form-select {
            width: 100%;
            padding: 10px 14px;
            font-size: 0.83rem;
            font-family: 'DM Sans', sans-serif;
            border: 1px solid var(--border);
            border-radius: var(--r-lg);
            color: var(--ink);
            background: var(--white);
            box-shadow: var(--sh-xs);
            transition: all 0.18s ease;
            outline: none;
        }

        .form-control:focus, .form-select:focus {
            border-color: var(--brand);
            box-shadow: 0 0 0 3px rgba(122,98,84,0.15);
        }

        .form-group { margin-bottom: 20px; }
        .form-label { 
            display: block; 
            font-size: 0.78rem; 
            font-weight: 600; 
            color: var(--ink-3); 
            margin-bottom: 8px; 
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .invalid-feedback { 
            display: block; 
            font-size: 0.72rem; 
            color: var(--rose); 
            margin-top: 6px; 
            font-weight: 500; 
        }

        label, .form-label {
            font-size: 0.76rem;
            font-weight: 600;
            color: var(--ink-2);
            margin-bottom: 6px;
            display: block;
            letter-spacing: 0.2px;
        }

        /* ────────────────────────────────────────
           ALERTS
        ──────────────────────────────────────── */
        .alert {
            border-radius: var(--r-lg);
            padding: 14px 18px;
            font-size: 0.83rem;
            border-left: 4px solid;
            display: flex;
            align-items: flex-start;
            gap: 12px;
        }

        .alert-success { background: var(--emerald-bg); border-color: var(--emerald); color: #065f46; }
        .alert-warning { background: var(--amber-bg); border-color: #d97706; color: #78350f; }
        .alert-danger  { background: var(--rose-bg); border-color: var(--rose); color: #9f1239; }

        /* ────────────────────────────────────────
           PAGINATION
        ──────────────────────────────────────── */
        .pagination { display: flex; gap: 4px; }

        .page-link {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 36px; height: 36px;
            font-size: 0.80rem;
            font-weight: 600;
            border-radius: var(--r-md);
            border: 1px solid var(--border);
            background: var(--white);
            color: var(--ink-2);
            text-decoration: none;
            transition: all 0.15s ease;
        }

        .page-link:hover { background: var(--brand-pale); border-color: var(--brand-lt); color: var(--brand); }

        .page-link.active {
            background: var(--brand);
            border-color: var(--brand);
            color: #fff;
            box-shadow: var(--sh-brand);
        }

        /* ────────────────────────────────────────
           FOOTER
        ──────────────────────────────────────── */
        .footer {
            text-align: center;
            font-size: 0.70rem;
            color: var(--ink-4);
            border-top: 1px solid var(--border);
            padding: 24px 0 0;
            margin-top: 48px;
            letter-spacing: 0.3px;
        }

        /* ────────────────────────────────────────
           PRELOADER
        ──────────────────────────────────────── */
        .preloader {
            position: fixed;
            inset: 0;
            z-index: 99999;
            background: var(--white);
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            gap: 18px;
            transition: opacity 0.4s ease, visibility 0.4s ease;
        }

        .preloader.hidden { opacity: 0; visibility: hidden; pointer-events: none; }

        .pre-brand {
            font-family: 'Cormorant Garamond', serif;
            font-size: 1.6rem;
            font-weight: 400;
            color: var(--brand);
            letter-spacing: 2px;
        }

        .pre-dots {
            display: flex; gap: 6px;
        }

        .pre-dots span {
            width: 8px; height: 8px;
            background: var(--brand-lt);
            border-radius: 50%;
            animation: dotPulse 1.4s ease infinite;
        }

        .pre-dots span:nth-child(2) { animation-delay: 0.2s; }
        .pre-dots span:nth-child(3) { animation-delay: 0.4s; }

        @keyframes dotPulse {
            0%, 80%, 100% { transform: scale(0.7); opacity: 0.4; }
            40% { transform: scale(1.1); opacity: 1; }
        }

        /* ────────────────────────────────────────
           SIDEBAR COLLAPSED
        ──────────────────────────────────────── */
        body.sb-collapsed .left-sidebar { width: var(--sidebar-w-sm); }

        body.sb-collapsed .brand-text,
        body.sb-collapsed .logo-text,
        body.sb-collapsed .sidebar-link span,
        body.sb-collapsed .nav-cap,
        body.sb-collapsed .has-arrow::after,
        body.sb-collapsed .first-level,
        body.sb-collapsed .logout-btn span { display: none !important; }

        body.sb-collapsed .sidebar-brand img { height: 32px; }

        body.sb-collapsed .sidebar-brand { justify-content: center; padding: 0; }
        body.sb-collapsed .sidebar-link { justify-content: center; padding: 9px; }
        body.sb-collapsed .sidebar-link i { width: auto; }
        body.sb-collapsed .sidebar-item { padding: 1px 6px; }
        body.sb-collapsed .logout-btn { justify-content: center; padding: 9px; }

        /* ────────────────────────────────────────
           MOBILE
        ──────────────────────────────────────── */
        .sidebar-overlay {
            position: fixed; inset: 0;
            background: rgba(30,21,16,0.55);
            backdrop-filter: blur(3px);
            z-index: 1038;
            visibility: hidden; opacity: 0;
            transition: opacity 0.25s ease, visibility 0.25s ease;
        }

        @media (max-width: 992px) {
            .left-sidebar {
                transform: translateX(-100%);
                transition: transform 0.28s cubic-bezier(0.4,0,0.2,1);
            }

            .topbar { padding-left: 0; }
            .page-wrapper { margin-left: 0; }

            body.mob-open .left-sidebar { transform: translateX(0); }
            body.mob-open .sidebar-overlay { visibility: visible; opacity: 1; }

            .page-inner { padding: 20px 16px 40px; }
            .topbar-search { display: none; }
        }

        /* ────────────────────────────────────────
           MISC UTILITIES
        ──────────────────────────────────────── */
        .fade-up { animation: fadeUp 0.45s ease forwards; opacity: 0; transform: translateY(14px); }

        @keyframes fadeUp {
            to { opacity: 1; transform: translateY(0); }
        }

        .grid-2 { display: grid; grid-template-columns: repeat(2, 1fr); gap: 24px; width: 100%; clear: both; margin-bottom: 32px; }
        .grid-3 { display: grid; grid-template-columns: repeat(3, 1fr); gap: 24px; width: 100%; clear: both; margin-bottom: 32px; }
        .grid-4 { display: grid; grid-template-columns: repeat(4, 1fr); gap: 24px; width: 100%; clear: both; margin-bottom: 32px; }

        @media (max-width: 1200px) { .grid-4 { grid-template-columns: repeat(2, 1fr); } }
        @media (max-width: 768px) { .grid-2, .grid-3, .grid-4 { grid-template-columns: 1fr; } }

        ::-webkit-scrollbar { width: 5px; height: 5px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: var(--border-md); border-radius: 10px; }
        ::-webkit-scrollbar-thumb:hover { background: var(--brand-lt); }

        /* ────────────────────────────────────────
           DEMO CONTENT STYLES (for preview)
        ──────────────────────────────────────── */
        .demo-avatar {
            width: 36px; height: 36px;
            border-radius: 50%;
            background: var(--brand-pale);
            border: 2px solid var(--border);
            display: flex; align-items: center; justify-content: center;
            font-size: 0.70rem;
            font-weight: 700;
            color: var(--brand-dk);
        }

        .trend-up { color: var(--emerald); font-size: 0.75rem; font-weight: 600; }
        .trend-dn { color: var(--rose); font-size: 0.75rem; font-weight: 600; }

        .mini-chart {
            display: flex;
            align-items: flex-end;
            gap: 3px;
            height: 36px;
        }

        .mini-bar {
            width: 6px;
            border-radius: 3px;
            background: var(--brand-pale);
            transition: height 0.4s ease;
        }

        .mini-bar.active { background: var(--brand); }

        .section-title {
            font-family: 'Cormorant Garamond', serif;
            font-size: 1.35rem;
            font-weight: 400;
            color: var(--ink);
            margin-bottom: 16px;
        }

        .chip {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            padding: 4px 12px;
            font-size: 0.70rem;
            font-weight: 600;
            border-radius: 20px;
            background: var(--brand-pale);
            color: var(--brand-dk);
            border: 1px solid var(--border);
        }

        /* Sidebar badge count */
        .sb-count {
            margin-left: auto;
            background: var(--brand);
            color: #fff;
            font-size: 0.58rem;
            font-weight: 700;
            padding: 2px 7px;
            border-radius: 20px;
        }

        body.sb-collapsed .sb-count { display: none; }
    </style>
</head>
<body>

<!-- PRELOADER -->
<div class="preloader" id="preloader">
    <div class="pre-brand">Nyonya Crumb</div>
    <div class="pre-dots">
        <span></span><span></span><span></span>
    </div>
</div>

<div class="sidebar-overlay" id="sidebarOverlay"></div>

<!-- ══════════════ SIDEBAR ══════════════ -->
<aside class="left-sidebar" id="sidebar">

    <a class="sidebar-brand" href="{{ route('backend.beranda') }}">
        <img src="{{ asset('image/nyonyacrumb.png') }}" alt="Nyonya Crumb Logo" style="height: 38px; width: auto; max-width: 100%; object-fit: contain;">
        <div class="logo-text">
            <span class="logo-text-main">Nyonya Crumb</span>
        </div>
    </a>

    <div class="scroll-sidebar">
        <nav class="sidebar-nav">
            <ul id="sidebarnav">

                <li class="nav-cap">Overview</li>

                <li class="sidebar-item {{ request()->routeIs('backend.beranda') ? 'selected' : '' }}">
                    <a class="sidebar-link" href="{{ route('backend.beranda') }}">
                        <i class="ri-home-5-line"></i>
                        <span>Beranda</span>
                    </a>
                </li>

                <li class="sidebar-item {{ request()->routeIs('backend.electre.*') ? 'selected' : '' }}">
                    <a class="sidebar-link" href="{{ route('backend.electre.index') }}">
                        <i class="ri-bar-chart-box-line"></i>
                        <span>Dashboard SPK</span>
                    </a>
                </li>

                <div class="nav-div"></div>
                <li class="nav-cap">Manajemen</li>

                <li class="sidebar-item {{ request()->routeIs('backend.user.*') ? 'selected' : '' }}">
                    <a class="sidebar-link" href="{{ route('backend.user.index') }}">
                        <i class="ri-team-line"></i>
                        <span>User</span>
                    </a>
                </li>

                <li class="sidebar-item {{ request()->routeIs('backend.customer.*') ? 'selected' : '' }}">
                    <a class="sidebar-link" href="{{ route('backend.customer.index') }}">
                        <i class="ri-customer-service-2-line"></i>
                        <span>Pelanggan</span>
                    </a>
                </li>

                <li class="sidebar-item {{ request()->routeIs('backend.pesanan.*') ? 'selected' : '' }}">
                    <a class="sidebar-link" href="{{ route('backend.pesanan.index') }}">
                        <i class="ri-shopping-cart-line"></i>
                        <span>Pesanan</span>
                    </a>
                </li>

                <div class="nav-div"></div>
                <li class="nav-cap">Katalog</li>

                <li class="sidebar-item {{ request()->routeIs('backend.kategori.*', 'backend.produk.*') ? 'selected' : '' }}">
                    <a class="sidebar-link has-arrow" href="javascript:void(0)" id="produkToggle" aria-expanded="{{ request()->routeIs('backend.kategori.*', 'backend.produk.*') ? 'true' : 'false' }}">
                        <i class="ri-cake-3-line"></i>
                        <span>Produk & Stok</span>
                    </a>
                    <ul class="first-level collapse" id="produkSub" style="{{ request()->routeIs('backend.kategori.*', 'backend.produk.*') ? 'display:block;' : '' }}">
                        <li class="sidebar-item {{ request()->routeIs('backend.kategori.*') ? 'selected' : '' }}">
                            <a class="sidebar-link" href="{{ route('backend.kategori.index') }}">
                                <i class="ri-circle-line"></i> <span>Kategori</span>
                            </a>
                        </li>
                        <li class="sidebar-item {{ request()->routeIs('backend.produk.*') ? 'selected' : '' }}">
                            <a class="sidebar-link" href="{{ route('backend.produk.index') }}">
                                <i class="ri-circle-line"></i> <span>Semua Produk</span>
                            </a>
                        </li>
                    </ul>
                </li>

                <div class="nav-div"></div>
                <li class="nav-cap">Laporan</li>

                <li class="sidebar-item {{ request()->routeIs('backend.laporan.*') ? 'selected' : '' }}">
                    <a class="sidebar-link has-arrow" href="javascript:void(0)" id="laporanToggle" aria-expanded="{{ request()->routeIs('backend.laporan.*') ? 'true' : 'false' }}">
                        <i class="ri-printer-line"></i>
                        <span>Cetak Laporan</span>
                    </a>
                    <ul class="first-level collapse" id="laporanSub" style="{{ request()->routeIs('backend.laporan.*') ? 'display:block;' : '' }}">
                        <li class="sidebar-item {{ request()->routeIs('backend.laporan.formuser') ? 'selected' : '' }}">
                            <a class="sidebar-link" href="{{ route('backend.laporan.formuser') }}"><i class="ri-circle-line"></i> <span>Laporan User</span></a>
                        </li>
                        <li class="sidebar-item {{ request()->routeIs('backend.laporan.formproduk') ? 'selected' : '' }}">
                            <a class="sidebar-link" href="{{ route('backend.laporan.formproduk') }}"><i class="ri-circle-line"></i> <span>Laporan Produk</span></a>
                        </li>
                        <li class="sidebar-item {{ request()->routeIs('backend.laporan.formpenjualan') ? 'selected' : '' }}">
                            <a class="sidebar-link" href="{{ route('backend.laporan.formpenjualan') }}"><i class="ri-circle-line"></i> <span>Laporan Penjualan</span></a>
                        </li>
                    </ul>
                </li>

            </ul>
        </nav>
    </div>

    <div class="sidebar-foot">
        <button class="logout-btn" onclick="event.preventDefault(); document.getElementById('keluar-app').submit();">
            <i class="ri-logout-box-r-line"></i>
            <span>Keluar</span>
        </button>
    </div>

</aside>

<!-- ══════════════ TOPBAR ══════════════ -->
<header class="topbar">
    <div class="topbar-inner">
        <!-- Sidebar Toggle -->
        <button class="toggler-btn" id="mainToggle" title="Toggle sidebar">
            <i class="ri-layout-left-2-line"></i>
        </button>



        <div class="topbar-right">
            <!-- Clock -->
            <div class="live-clock d-none d-lg-block" id="topClock"></div>



            <!-- User -->
            <div class="user-menu">
                <a class="user-btn" href="#" id="userMenuBtn">
                    @if(Auth::user()->foto)
                        <img src="{{ asset('storage/img-user/' . Auth::user()->foto) }}" class="user-avatar" alt="Admin">
                    @else
                        <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->nama ?? 'Admin') }}&background=7a6254&color=fff&size=64" class="user-avatar" alt="Admin">
                    @endif
                    <div class="user-info d-none d-lg-block">
                        <div class="u-name">{{ Auth::user()->nama ?? 'Administrator' }}</div>
                        <div class="u-role">{{ (Auth::user()->role ?? 1) == 1 ? 'Administrator' : 'User' }}</div>
                    </div>
                    <i class="ri-arrow-down-s-line d-none d-lg-inline" style="font-size:0.85rem;color:var(--ink-4);margin-left:2px;"></i>
                </a>

                <div class="user-dropdown" id="userDropdown">
                    <div class="drop-header">
                        <div class="dh-name">{{ Auth::user()->nama ?? 'Administrator' }}</div>
                        <div class="dh-email">{{ Auth::user()->email ?? 'admin@nyonyacrumb.com' }}</div>
                    </div>
                    <a class="drop-item" href="{{ route('backend.user.edit', Auth::user()->id) }}">
                        <i class="ri-user-settings-line"></i> Profil Saya
                    </a>
                    <div class="drop-divider"></div>
                    <button class="drop-item danger" onclick="event.preventDefault(); document.getElementById('keluar-app').submit();">
                        <i class="ri-logout-box-r-line"></i> Keluar
                    </button>
                </div>
            </div>
        </div>
    </div>
</header>

<!-- ══════════════ PAGE CONTENT ══════════════ -->
<div class="page-wrapper">
    <div class="page-inner">

        @yield('content')

    </div>
</div>

<!-- Logout form placeholder -->
<form id="keluar-app" action="{{ route('backend.logout') }}" method="POST" style="display:none;">@csrf</form>

<script>
    /* Preloader */
    window.addEventListener('load', function () {
        setTimeout(function () {
            const p = document.getElementById('preloader');
            if (p) { p.classList.add('hidden'); }
        }, 800);
    });

    /* Clock */
    function updateClock() {
        const d = new Date();
        const opt = { weekday:'short', day:'numeric', month:'short', hour:'2-digit', minute:'2-digit', second:'2-digit', hour12:false };
        const el = document.getElementById('topClock');
        if (el) el.textContent = d.toLocaleString('id-ID', opt);
    }
    updateClock();
    setInterval(updateClock, 1000);

    /* Main sidebar toggle */
    document.getElementById('mainToggle').addEventListener('click', function () {
        if (window.innerWidth <= 992) {
            document.body.classList.toggle('mob-open');
        } else {
            document.body.classList.toggle('sb-collapsed');
        }
    });

    document.getElementById('sidebarOverlay').addEventListener('click', function () {
        document.body.classList.remove('mob-open');
    });

    /* User dropdown */
    const userBtn = document.getElementById('userMenuBtn');
    const userDrop = document.getElementById('userDropdown');

    userBtn.addEventListener('click', function (e) {
        e.preventDefault();
        userDrop.classList.toggle('open');
    });

    document.addEventListener('click', function (e) {
        if (!userBtn.contains(e.target) && !userDrop.contains(e.target)) {
            userDrop.classList.remove('open');
        }
    });

    /* Submenu toggles */
    function setupSubmenu(toggleId, subId) {
        const toggle = document.getElementById(toggleId);
        const sub = document.getElementById(subId);
        if (!toggle || !sub) return;

        toggle.addEventListener('click', function (e) {
            e.preventDefault();
            
            // Jika sidebar sedang ciut (collapsed), rentangkan terlebih dahulu
            if (document.body.classList.contains('sb-collapsed')) {
                document.body.classList.remove('sb-collapsed');
                toggle.setAttribute('aria-expanded', 'true');
                sub.style.display = 'block';
                return;
            }

            const isOpen = toggle.getAttribute('aria-expanded') === 'true';
            toggle.setAttribute('aria-expanded', !isOpen);
            sub.style.display = isOpen ? 'none' : 'block';
        });
    }

    setupSubmenu('produkToggle', 'produkSub');
    setupSubmenu('laporanToggle', 'laporanSub');
</script>

</body>
</html>