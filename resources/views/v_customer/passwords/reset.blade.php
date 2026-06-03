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
    }
    .auth-card {
        background: var(--bg-white);
        width: 100%;
        max-width: 450px;
        padding: 50px 40px;
        border-radius: var(--radius-md);
        box-shadow: var(--shadow-sm);
        border: 1px solid var(--border);
    }
    .auth-title {
        text-align: center;
        color: var(--text-dark);
        font-family: 'Cormorant Garamond', serif;
        font-weight: 600;
        font-size: 32px;
        margin-bottom: 15px;
    }
    .auth-desc {
        text-align: center;
        color: var(--text-muted);
        font-size: 14px;
        margin-bottom: 30px;
        line-height: 1.6;
    }
    .form-group-nc { margin-bottom: 25px; }
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
    }
    .btn-submit-nc:hover { background: var(--primary); }
    .alert-custom {
        border-radius: var(--radius-sm);
        border: none;
        font-size: 14px;
        padding: 15px 20px;
        background: #FFEBEE;
        color: #C62828;
        margin-bottom: 20px;
    }
</style>

<div class="auth-section">
    <div class="container">
        <div class="auth-card mx-auto">
            <h3 class="auth-title">Buat Password Baru</h3>
            <p class="auth-desc">Silakan masukkan password baru Anda. Pastikan password kuat dan mudah diingat.</p>
            
            @if ($errors->any())
                <div class="alert alert-custom">
                    <ul style="margin: 0; padding-left: 15px;">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('auth.reset-password.submit') }}" method="POST">
                @csrf
                <div class="form-group-nc">
                    <label>Password Baru</label>
                    <input type="password" name="password" class="form-control-nc" placeholder="Minimal 8 karakter" required>
                </div>
                
                <div class="form-group-nc">
                    <label>Konfirmasi Password</label>
                    <input type="password" name="password_confirmation" class="form-control-nc" placeholder="Ketik ulang password baru" required>
                </div>
                
                <button type="submit" class="btn-submit-nc">Simpan Password Baru</button>
            </form>
        </div>
    </div>
</div>
@endsection
