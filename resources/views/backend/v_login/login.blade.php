<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
    <title>Nyonya Crumb · Admin Panel</title>
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('image/nyonyacrumb.png') }}">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,400;0,600;1,300;1,400&family=Jost:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <style>
        *, *::before, *::after { margin: 0; padding: 0; box-sizing: border-box; }

        :root {
            --sand:        #F5EDE0;
            --parchment:   #FDF8F2;
            --linen:       #EDE3D5;
            --cocoa:       #8B6347;
            --cocoa-deep:  #5C3D25;
            --gold:        #C8A96E;
            --gold-muted:  #B89458;
            --ink:         #2A1F15;
            --ink-soft:    #6B5040;
            --white:       #FFFFFF;
            --error:       #C0654A;
            --page-bg:     #E8DDD1;
        }

        html, body {
            width: 100%;
            min-height: 100vh;
            overflow-x: hidden;
        }

        body {
            font-family: 'Jost', sans-serif;
            background-color: var(--page-bg);
            background-image:
                radial-gradient(ellipse 80% 60% at 20% 110%, rgba(139,99,71,0.18) 0%, transparent 60%),
                radial-gradient(ellipse 60% 50% at 85% -10%,  rgba(200,169,110,0.12) 0%, transparent 55%);
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            padding: 32px 20px;
            perspective: 1800px;
        }

        /* ── grain overlay ── */
        body::before {
            content: '';
            position: fixed;
            inset: 0;
            pointer-events: none;
            z-index: 0;
            background-image: url("data:image/svg+xml,%3Csvg viewBox='0 0 256 256' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='n'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.9' numOctaves='4' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23n)' opacity='0.04'/%3E%3C/svg%3E");
            background-repeat: repeat;
            background-size: 180px 180px;
            opacity: 0.55;
        }

        /* ═══════════════════════════════════════
           BOOK SCENE
        ═══════════════════════════════════════ */
        .scene {
            position: relative;
            z-index: 1;
            width: min(960px, 100%);
            transform-style: preserve-3d;
        }

        .book {
            display: flex;
            width: 100%;
            transform-style: preserve-3d;
            border-radius: 6px 32px 32px 6px;
            box-shadow:
                -6px 12px 0 0 rgba(0,0,0,0.06),
                0   32px 80px -12px rgba(42,31,21,0.28),
                0    8px 24px -4px  rgba(42,31,21,0.18);

            /* entry: entire book drops in */
            opacity: 0;
            animation: bookEntry 0.9s cubic-bezier(0.22,1,0.36,1) 0.1s forwards;
        }

        @keyframes bookEntry {
            from { opacity: 0; transform: translateY(28px) rotateX(4deg); }
            to   { opacity: 1; transform: translateY(0)   rotateX(0deg); }
        }

        /* ── SPINE ── */
        .spine {
            width: 14px;
            flex-shrink: 0;
            background: linear-gradient(to right, #3D2512 0%, #6B3E1E 40%, #7A4B24 60%, #5A3018 100%);
            border-radius: 6px 0 0 6px;
            position: relative;
            box-shadow: inset -3px 0 8px rgba(0,0,0,0.35);
        }
        .spine::after {
            content: '';
            position: absolute;
            top: 0; left: 3px; width: 2px; height: 100%;
            background: linear-gradient(to bottom, transparent 0%, rgba(255,255,255,0.08) 50%, transparent 100%);
        }

        /* ── LEFT PANEL (cover that opens) ── */
        .cover-wrap {
            flex: 1;
            position: relative;
            transform-style: preserve-3d;
            transform-origin: right center;
            animation: coverOpen 1.4s cubic-bezier(0.25, 0.85, 0.2, 1.0) 0.55s both;
        }

        @keyframes coverOpen {
            0%   { transform: rotateY(178deg); }
            60%  { transform: rotateY(-6deg); }
            80%  { transform: rotateY(2deg); }
            100% { transform: rotateY(0deg); }
        }

        /* Inner page (visible when open) */
        .cover-inner {
            width: 100%;
            height: 100%;
            min-height: 560px;
            background: linear-gradient(150deg, var(--parchment) 0%, var(--sand) 100%);
            padding: 52px 44px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            backface-visibility: hidden;
            -webkit-backface-visibility: hidden;
            border-right: 1px solid rgba(139,99,71,0.12);
            position: relative;
            overflow: hidden;
        }

        /* subtle page texture lines */
        .cover-inner::before {
            content: '';
            position: absolute;
            top: 0; left: 0; right: 0; bottom: 0;
            background-image: repeating-linear-gradient(
                transparent,
                transparent 27px,
                rgba(139,99,71,0.04) 27px,
                rgba(139,99,71,0.04) 28px
            );
            pointer-events: none;
        }

        /* Outer cover (visible before opening) */
        .cover-outer {
            position: absolute;
            inset: 0;
            background: linear-gradient(145deg, #6B3719 0%, #3E2010 100%);
            backface-visibility: hidden;
            -webkit-backface-visibility: hidden;
            transform: rotateY(180deg);
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
            gap: 18px;
            overflow: hidden;
        }
        .cover-outer::before {
            content: '';
            position: absolute;
            inset: 16px;
            border: 1px solid rgba(200,169,110,0.22);
            border-radius: 4px;
            pointer-events: none;
        }
        .cover-outer::after {
            content: '';
            position: absolute;
            inset: 20px;
            border: 1px solid rgba(200,169,110,0.10);
            border-radius: 3px;
            pointer-events: none;
        }
        .cover-outer-logo {
            height: 72px;
            filter: brightness(0) invert(1) opacity(0.85);
        }
        .cover-outer-title {
            font-family: 'Cormorant Garamond', serif;
            font-size: 38px;
            font-weight: 300;
            color: rgba(255,255,255,0.92);
            letter-spacing: 3px;
            text-align: center;
        }
        .cover-outer-sub {
            font-size: 10px;
            letter-spacing: 5px;
            text-transform: uppercase;
            color: var(--gold);
            font-weight: 500;
        }

        /* ── Page-turn shadow line ── */
        .page-shadow {
            position: absolute;
            right: 0; top: 0; bottom: 0;
            width: 32px;
            background: linear-gradient(to left, rgba(42,31,21,0.10) 0%, transparent 100%);
            pointer-events: none;
            z-index: 3;
        }

        /* ── Brand content (inner) ── */
        .brand-logo img {
            height: 40px;
            filter: drop-shadow(0 1px 3px rgba(139,99,71,0.2));
        }

        .brand-body {
            flex: 1;
            display: flex;
            flex-direction: column;
            justify-content: center;
            padding: 32px 0;
        }

        .brand-title {
            font-family: 'Cormorant Garamond', serif;
            font-size: 52px;
            font-weight: 300;
            line-height: 1.12;
            color: var(--ink);
            margin-bottom: 18px;
        }
        .brand-title em {
            font-style: italic;
            color: var(--cocoa);
            font-weight: 400;
        }

        .brand-desc {
            font-size: 14px;
            font-weight: 300;
            line-height: 1.75;
            color: var(--ink-soft);
            max-width: 85%;
        }

        .brand-foot {
            display: flex;
            flex-direction: column;
            gap: 8px;
        }
        .divider-line {
            display: flex;
            align-items: center;
            gap: 14px;
        }
        .divider-line::before,
        .divider-line::after {
            content: '';
            flex: 1;
            height: 1px;
            background: linear-gradient(to right, transparent, rgba(139,99,71,0.25), transparent);
        }
        .divider-text {
            font-size: 10px;
            font-weight: 600;
            letter-spacing: 4px;
            color: var(--gold-muted);
        }
        .brand-tagline {
            font-size: 10px;
            letter-spacing: 3px;
            text-transform: uppercase;
            color: rgba(107,80,64,0.55);
            font-weight: 500;
        }

        /* ── RIGHT PANEL (form, static page) ── */
        .form-page {
            flex: 1;
            background: var(--white);
            padding: 56px 52px 52px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            border-radius: 0 32px 32px 0;
            position: relative;
            overflow: hidden;
        }

        /* decorative gold corner accent */
        .form-page::before {
            content: '';
            position: absolute;
            top: 0; right: 0;
            width: 120px; height: 120px;
            background: radial-gradient(circle at top right, rgba(200,169,110,0.08) 0%, transparent 70%);
        }

        /* page edge effect */
        .form-page::after {
            content: '';
            position: absolute;
            right: -6px; top: 4%; bottom: 4%;
            width: 6px;
            background: linear-gradient(to right, #E8E0D8, #D8D0C8);
            border-radius: 0 3px 3px 0;
            box-shadow: 2px 0 5px rgba(0,0,0,0.08);
        }

        /* content stagger animation */
        .form-page > * {
            opacity: 0;
            animation: staggerIn 0.55s ease forwards;
        }
        .form-page > *:nth-child(1) { animation-delay: 1.55s; }
        .form-page > *:nth-child(2) { animation-delay: 1.65s; }
        .form-page > *:nth-child(3) { animation-delay: 1.75s; }
        .form-page > *:nth-child(4) { animation-delay: 1.85s; }

        @keyframes staggerIn {
            from { opacity: 0; transform: translateY(14px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        /* ── Form header ── */
        .form-eyebrow {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 6px;
        }
        .form-eyebrow-line {
            width: 24px;
            height: 1px;
            background: var(--gold);
        }
        .form-eyebrow span {
            font-size: 10px;
            font-weight: 600;
            letter-spacing: 3.5px;
            text-transform: uppercase;
            color: var(--gold);
        }

        .form-heading {
            font-family: 'Cormorant Garamond', serif;
            font-size: 40px;
            font-weight: 400;
            color: var(--ink);
            line-height: 1.15;
            margin-bottom: 36px;
        }
        .form-heading em {
            font-style: italic;
            color: var(--cocoa);
        }

        /* ── Alert ── */
        .alert-box {
            background: #FDF4F0;
            border-radius: 12px;
            padding: 12px 18px;
            margin-bottom: 28px;
            display: flex;
            align-items: center;
            gap: 12px;
            border-left: 3px solid var(--error);
            font-size: 13px;
            font-weight: 400;
            color: var(--error);
            animation: shake 0.4s ease;
        }
        @keyframes shake {
            0%,100% { transform: translateX(0); }
            25%      { transform: translateX(-4px); }
            75%      { transform: translateX(4px); }
        }

        /* ── Inputs ── */
        .field + .field { margin-top: 22px; }

        .field-label {
            display: block;
            font-size: 10px;
            font-weight: 600;
            letter-spacing: 2.5px;
            text-transform: uppercase;
            color: var(--ink-soft);
            margin-bottom: 9px;
        }

        .field-wrap {
            position: relative;
        }

        .field-icon {
            position: absolute;
            left: 17px;
            top: 50%;
            transform: translateY(-50%);
            font-size: 13px;
            color: var(--gold-muted);
            pointer-events: none;
        }

        .field-input {
            width: 100%;
            padding: 14px 18px 14px 44px;
            font-family: 'Jost', sans-serif;
            font-size: 14.5px;
            font-weight: 400;
            background: var(--parchment);
            border: 1.5px solid var(--linen);
            border-radius: 12px;
            color: var(--ink);
            transition: border-color 0.22s, box-shadow 0.22s, background 0.22s;
        }
        .field-input::placeholder { color: rgba(107,80,64,0.35); font-weight: 300; }
        .field-input:focus {
            outline: none;
            background: #fff;
            border-color: var(--gold);
            box-shadow: 0 0 0 3px rgba(200,169,110,0.14);
        }
        .field-input.is-invalid {
            border-color: rgba(192,101,74,0.45);
            background: #FFF8F6;
        }

        .field-toggle {
            position: absolute;
            right: 16px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            font-size: 14px;
            color: rgba(107,80,64,0.45);
            cursor: pointer;
            transition: color 0.2s;
        }
        .field-toggle:hover { color: var(--cocoa); }

        .field-error {
            display: block;
            font-size: 12px;
            margin-top: 7px;
            margin-left: 4px;
            color: var(--error);
            font-weight: 400;
        }

        /* ── Submit ── */
        .btn-submit {
            margin-top: 34px;
            width: 100%;
            padding: 15px 24px;
            background: var(--cocoa-deep);
            border: none;
            border-radius: 12px;
            font-family: 'Jost', sans-serif;
            font-size: 12px;
            font-weight: 600;
            letter-spacing: 2.5px;
            text-transform: uppercase;
            color: #fff;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 12px;
            transition: background 0.25s, transform 0.2s, box-shadow 0.25s;
            box-shadow: 0 4px 16px rgba(92,61,37,0.25), 0 1px 3px rgba(92,61,37,0.18);
        }
        .btn-submit:hover:not(:disabled) {
            background: var(--cocoa);
            transform: translateY(-1px);
            box-shadow: 0 8px 24px rgba(92,61,37,0.28);
        }
        .btn-submit:active:not(:disabled) {
            transform: translateY(1px);
            box-shadow: 0 2px 8px rgba(92,61,37,0.2);
        }
        .btn-submit:disabled { opacity: 0.75; cursor: not-allowed; }

        .btn-submit .arrow-icon { transition: transform 0.2s; }
        .btn-submit:hover:not(:disabled) .arrow-icon { transform: translateX(4px); }

        .spinner {
            width: 16px; height: 16px;
            border: 2px solid rgba(255,255,255,0.3);
            border-top-color: #fff;
            border-radius: 50%;
            animation: spin 0.65s linear infinite;
        }
        @keyframes spin { to { transform: rotate(360deg); } }

        /* ── Responsive ── */
        @media (max-width: 780px) {
            body { perspective: none; }

            .book {
                flex-direction: column;
                border-radius: 20px;
                animation: bookEntry 0.7s ease 0.1s both;
            }
            .spine { width: 100%; height: 10px; border-radius: 20px 20px 0 0; }
            .spine::after { display: none; }
            .cover-wrap {
                animation: none;
                transform: rotateY(0deg);
            }
            .cover-outer { display: none; }
            .cover-inner {
                min-height: unset;
                border-right: none;
                border-bottom: 1px solid var(--linen);
                padding: 36px 32px;
            }
            .brand-title { font-size: 38px; }
            .form-page {
                border-radius: 0 0 20px 20px;
                padding: 40px 32px 40px;
            }
            .form-page::after { display: none; }
            .form-page > * { animation-delay: 0.5s; opacity: 1; }
            .page-shadow { display: none; }
        }

        @media (max-width: 480px) {
            .cover-inner { padding: 28px 24px; }
            .brand-title { font-size: 32px; }
            .form-page { padding: 32px 24px; }
            .form-heading { font-size: 32px; }
        }
    </style>
</head>
<body>

<div class="scene">
    <div class="book">

        <!-- ── SPINE ── -->
        <div class="spine"></div>

        <!-- ── LEFT: Cover that opens ── -->
        <div class="cover-wrap">
            <!-- Inner page content -->
            <div class="cover-inner">
                <div class="page-shadow"></div>

                <div class="brand-logo">
                    <img src="{{ asset('image/nyonyacrumb.png') }}" alt="Nyonya Crumb">
                </div>

                <div class="brand-body">
                    <h1 class="brand-title">Artisan<br><em>Admin Panel</em></h1>
                    <p class="brand-desc">Kelola toko kue kering homemade premium Nyonya Crumb dengan mudah dan elegan.</p>
                </div>

                <div class="brand-foot">
                    <div class="divider-line">
                        <span class="divider-text">Est. 2026</span>
                    </div>
                    <span class="brand-tagline">Nyonya Crumb · Artisan Homemade</span>
                </div>
            </div>

            <!-- Outer cover (seen before animation) -->
            <div class="cover-outer">
                <img src="{{ asset('image/nyonyacrumb.png') }}" alt="" class="cover-outer-logo">
                <div class="cover-outer-title">Nyonya Crumb</div>
                <div class="cover-outer-sub">Premium Artisan</div>
            </div>
        </div>

        <!-- ── RIGHT: Form page ── -->
        <div class="form-page">

            <!-- ═══ LOGIN PANEL ═══ -->
            <div id="panelLogin">
                <!-- Header -->
                <div class="form-eyebrow" style="margin-top:4px;">
                    <div class="form-eyebrow-line"></div>
                    <span>Masuk ke Dasbor</span>
                </div>
                <h2 class="form-heading" style="font-size:34px; margin-bottom:20px;">Selamat<br><em>Datang</em></h2>

                <!-- Alert -->
                @if(session()->has('error'))
                <div class="alert-box">
                    <i class="fas fa-exclamation-circle"></i>
                    <span>{{ session('error') }}</span>
                </div>
                @endif

                <form action="{{ route('backend.login') }}" method="post" id="loginForm">
                    @csrf

                    <div class="field">
                        <label class="field-label" for="username">Username</label>
                        <div class="field-wrap">
                            <i class="fas fa-user field-icon"></i>
                            <input
                                type="text"
                                id="username"
                                name="username"
                                value="{{ old('username') }}"
                                class="field-input @error('username') is-invalid @enderror"
                                placeholder="username_anda"
                                autocomplete="username"
                            >
                        </div>
                        @error('username')
                        <span class="field-error"><i class="fas fa-circle-exclamation"></i> {{ $message }}</span>
                        @enderror
                    </div>

                    <div class="field">
                        <label class="field-label" for="password">Kata Sandi</label>
                        <div class="field-wrap">
                            <i class="fas fa-lock field-icon"></i>
                            <input
                                type="password"
                                id="password"
                                name="password"
                                class="field-input @error('password') is-invalid @enderror"
                                placeholder="··········"
                                autocomplete="current-password"
                            >
                            <button type="button" class="field-toggle" id="togglePassword" aria-label="Tampilkan sandi">
                                <i class="far fa-eye-slash"></i>
                            </button>
                        </div>
                        @error('password')
                        <span class="field-error"><i class="fas fa-circle-exclamation"></i> {{ $message }}</span>
                        @enderror
                    </div>

                    <button type="submit" class="btn-submit" id="loginBtn">
                        <span>Masuk Sekarang</span>
                        <i class="fas fa-arrow-right arrow-icon"></i>
                    </button>
                </form>
            </div>

            <!-- spacer -->
            <div></div>
        </div>

    </div><!-- .book -->
</div><!-- .scene -->

<script>
(function () {
    // ── Login password toggle ──
    const pwd = document.getElementById('password');
    const tog = document.getElementById('togglePassword');
    if (pwd && tog) {
        tog.addEventListener('click', function () {
            const show = pwd.getAttribute('type') === 'password';
            pwd.setAttribute('type', show ? 'text' : 'password');
            const ico = tog.querySelector('i');
            if (ico) {
                ico.classList.toggle('fa-eye-slash', !show);
                ico.classList.toggle('fa-eye', show);
            }
        });
    }

    // ── Login loading state ──
    const loginForm = document.getElementById('loginForm');
    const loginBtn  = document.getElementById('loginBtn');
    if (loginForm && loginBtn) {
        loginForm.addEventListener('submit', function () {
            if (loginBtn.disabled) return;
            loginBtn.disabled = true;
            loginBtn.innerHTML = '<div class="spinner"></div><span>Memproses…</span>';
            setTimeout(function () {
                if (loginBtn.disabled) {
                    loginBtn.disabled = false;
                    loginBtn.innerHTML = '<span>Masuk Sekarang</span><i class="fas fa-arrow-right arrow-icon"></i>';
                }
            }, 6000);
        });
    }

    // ── Input subtle background on focus/blur ──
    document.querySelectorAll('.field-input').forEach(function (el) {
        el.addEventListener('focus',  function () { this.style.background = '#fff'; });
        el.addEventListener('blur',   function () { if (!this.value) this.style.background = ''; });
    });
})();
</script>

</body>
</html>