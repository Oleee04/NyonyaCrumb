@extends('v_layouts.app')

@section('content')
<style>
    .auth-section {
        min-height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 160px 20px 100px;
        background: var(--bg-creme);
        position: relative;
    }

    .auth-card {
        background: var(--bg-white);
        width: 100%;
        max-width: 480px;
        padding: 50px 40px;
        border-radius: var(--radius-md);
        box-shadow: var(--shadow-sm);
        border: 1px solid var(--border);
        position: relative;
        z-index: 2;
    }

    .auth-title {
        text-align: center;
        color: var(--text-dark);
        font-family: 'Cormorant Garamond', serif;
        font-weight: 600;
        font-size: 36px;
        margin-bottom: 30px;
    }

    .form-group-nc {
        margin-bottom: 25px;
    }

    .form-group-nc label {
        font-size: 11px;
        text-transform: uppercase;
        letter-spacing: 1.5px;
        font-weight: 600;
        color: var(--primary);
        margin-bottom: 10px;
        display: block;
    }

    .form-control-nc {
        width: 100%;
        padding: 14px 18px;
        border: 1px solid var(--border);
        background: var(--bg-creme);
        border-radius: var(--radius-sm);
        font-family: 'DM Sans', sans-serif;
        font-size: 14px;
        color: var(--text-dark);
        transition: 0.3s;
    }

    .form-control-nc:focus {
        outline: none;
        border-color: var(--text-dark);
        background: var(--bg-white);
        box-shadow: 0 0 0 2px rgba(62, 39, 35, 0.05);
    }

    .password-toggle {
        position: absolute;
        right: 15px;
        top: 38px;
        cursor: pointer;
        color: var(--text-muted);
        transition: 0.3s;
    }
    
    .password-toggle:hover {
        color: var(--text-dark);
    }

    .forgot-link {
        display: block;
        text-align: right;
        font-size: 13px;
        color: var(--text-muted);
        text-decoration: none;
        margin-top: 8px;
        transition: 0.3s;
    }

    .forgot-link:hover {
        color: var(--text-dark);
    }

    .btn-submit-nc {
        background: var(--text-dark);
        color: white;
        border: none;
        padding: 16px;
        font-size: 12px;
        letter-spacing: 2px;
        text-transform: uppercase;
        font-weight: 600;
        cursor: pointer;
        transition: 0.3s;
        width: 100%;
        border-radius: var(--radius-sm);
        margin-top: 10px;
    }

    .btn-submit-nc:hover {
        background: var(--primary);
    }

    .auth-divider {
        display: flex;
        align-items: center;
        text-align: center;
        margin: 30px 0;
        color: var(--text-muted);
        font-size: 13px;
    }

    .auth-divider::before, .auth-divider::after {
        content: "";
        flex: 1;
        border-bottom: 1px solid var(--border);
    }

    .auth-divider span {
        padding: 0 15px;
    }

    .btn-google-nc {
        background: white;
        color: var(--text-dark);
        border: 1px solid var(--border);
        border-radius: var(--radius-sm);
        padding: 14px;
        font-size: 13px;
        font-weight: 600;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 12px;
        transition: 0.3s;
        text-decoration: none;
        width: 100%;
    }

    .btn-google-nc img {
        width: 20px;
        height: 20px;
    }

    .btn-google-nc:hover {
        background: var(--bg-creme);
        border-color: var(--primary);
    }

    .auth-footer {
        text-align: center;
        margin-top: 30px;
        font-size: 14px;
        color: var(--text-muted);
    }

    .auth-footer a {
        color: var(--primary);
        font-weight: 600;
        text-decoration: none;
        transition: 0.3s;
    }

    .auth-footer a:hover {
        color: var(--text-dark);
    }

    .alert-custom {
        border-radius: var(--radius-sm);
        border: none;
        font-size: 14px;
        padding: 15px 20px;
        background: #FFEBEE;
        color: #C62828;
        margin-bottom: 20px;
    }
    
    .alert-success-custom {
        background: #E8F5E9;
        color: #2E7D32;
    }

    @media (max-width: 768px) {
        .auth-card { padding: 40px 25px; }
    }
</style>

<div class="auth-section">
    <div class="container">
        <div class="auth-card reveal mx-auto">
            <h3 class="auth-title">Masuk ke Akun</h3>
            
            @if(session()->has('status'))
                <div class="alert alert-custom alert-success-custom">
                    {{ session('status') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="alert alert-custom">
                    <ul style="margin: 0; padding-left: 15px;">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('auth.login.submit') }}" method="POST">
                @csrf

                <div class="form-group-nc" style="position: relative;">
                    <label>Username</label>
                    <input type="text" name="username" class="form-control-nc" value="{{ old('username') }}" placeholder="username_anda" required autocomplete="username">
                </div>
                
                <div class="form-group-nc" style="position: relative;">
                    <label>Password</label>
                    <input type="password" name="password" id="password" class="form-control-nc" placeholder="Masukkan password Anda" required>
                    <i class="fa fa-eye password-toggle" onclick="togglePassword('password', this)"></i>
                    <a href="{{ url('auth/forgot-password') }}" class="forgot-link">Lupa Password?</a>
                </div>
                
                <button type="submit" class="btn-submit-nc">Masuk</button>
            </form>
            
            <div class="auth-divider">
                <span>Atau masuk dengan</span>
            </div>
            
            <a href="{{ route('auth.redirect') }}" class="btn-google-nc">
                <img src="https://upload.wikimedia.org/wikipedia/commons/5/53/Google_%22G%22_Logo.svg" alt="Google">
                Lanjutkan dengan Google
            </a>
            
            <div class="auth-footer">
                <p>Belum punya akun? <a href="{{ route('auth.register') }}">Daftar di sini</a></p>
            </div>
        </div>
    </div>
</div>

<script>
    function togglePassword(inputId, icon) {
        const input = document.getElementById(inputId);
        if (input.type === 'password') {
            input.type = 'text';
            icon.classList.remove('fa-eye');
            icon.classList.add('fa-eye-slash');
        } else {
            input.type = 'password';
            icon.classList.remove('fa-eye-slash');
            icon.classList.add('fa-eye');
        }
    }
</script>
@endsection
