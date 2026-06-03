@extends('v_layouts.app')

@section('content')
<style>
    .contact-section {
        padding: 60px 0;
    }

    .contact-card {
        background: var(--bg-white);
        border-radius: var(--radius-md);
        box-shadow: var(--shadow-md);
        padding: 40px;
        border: 1px solid var(--border);
        max-width: 900px;
        margin: 0 auto;
    }

    .title-badge {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        background: var(--bg-creme);
        padding: 6px 16px;
        border-radius: 40px;
        color: var(--primary);
        font-size: 11px;
        font-weight: 600;
        margin-bottom: 16px;
        letter-spacing: 1px;
        text-transform: uppercase;
        border: 1px solid var(--border);
    }

    .contact-card h1 {
        font-family: 'Cormorant Garamond', serif;
        font-size: 42px;
        font-weight: 500;
        margin-bottom: 8px;
        color: var(--text-dark);
    }

    .subtitle {
        color: var(--text-muted);
        margin-bottom: 32px;
        font-size: 15px;
    }

    .form-group {
        margin-bottom: 24px;
        text-align: left;
    }

    .form-group label {
        display: block;
        font-size: 13px;
        font-weight: 600;
        margin-bottom: 8px;
        color: var(--text-dark);
        letter-spacing: 0.5px;
    }

    .form-group label i {
        color: var(--primary);
        margin-right: 8px;
    }

    .form-control {
        width: 100%;
        padding: 14px 18px;
        border: 1px solid var(--border);
        border-radius: 0;
        font-family: 'DM Sans', sans-serif;
        font-size: 14px;
        transition: 0.3s;
        background: var(--bg-creme);
    }

    .form-control:focus {
        outline: none;
        border-color: var(--primary);
        background: white;
        box-shadow: none;
    }

    .btn-nc-submit {
        background: var(--text-dark);
        color: white;
        padding: 16px 40px;
        border-radius: 0;
        font-weight: 600;
        font-size: 11px;
        letter-spacing: 2px;
        text-transform: uppercase;
        border: none;
        cursor: pointer;
        transition: 0.3s;
        display: inline-flex;
        align-items: center;
        gap: 10px;
    }

    .btn-nc-submit:hover {
        background: var(--primary);
        transform: translateY(-2px);
    }

    .alert-custom {
        padding: 16px 20px;
        border-radius: 0;
        margin-bottom: 24px;
        font-size: 14px;
        border: 1px solid transparent;
    }

    .alert-success-custom {
        background: #f1f8f4;
        border-color: #d4edda;
        color: #155724;
    }

    .alert-danger-custom {
        background: #fff5f5;
        border-color: #f5c6cb;
        color: #721c24;
    }

    .footer-note {
        text-align: center;
        margin-top: 40px;
        font-size: 12px;
        color: var(--text-muted);
        letter-spacing: 0.5px;
        border-top: 1px solid var(--border);
        padding-top: 20px;
    }

    @media (max-width: 768px) {
        .contact-card { padding: 30px 20px; }
    }
</style>

<div class="container section-padding">
    <div class="contact-section reveal">
        <div class="contact-card">
            
            <div class="text-center">
                <div class="title-badge">
                    <i class="fas fa-envelope"></i> Hubungi Kami
                </div>
                <h1>Hubungi <span style="font-style: italic;">Kami</span></h1>
                <p class="subtitle">Ada pertanyaan? Tim Nyonya Crumb siap membantu Anda.</p>
            </div>

            <!-- Flash Message Success -->
            @if(session('success'))
                <div id="flash-success" class="alert-custom alert-success-custom">
                    <i class="fas fa-check-circle"></i> {{ session('success') }}
                </div>
            @endif

            <!-- Flash Message Error -->
            @if(session('error'))
                <div id="flash-error" class="alert-custom alert-danger-custom">
                    <i class="fas fa-exclamation-triangle"></i> {{ session('error') }}
                </div>
            @endif

            <!-- Error Validation -->
            @if($errors->any())
                <div class="alert-custom alert-danger-custom">
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
                    <label><i class="fas fa-user"></i> NAMA LENGKAP <span style="color: var(--primary);">*</span></label>
                    <input type="text" name="name" class="form-control" placeholder="Masukkan nama lengkap Anda" value="{{ old('name') }}" required>
                </div>

                <div class="form-group">
                    <label><i class="fas fa-envelope"></i> EMAIL <span style="color: var(--primary);">*</span></label>
                    <input type="email" name="email" class="form-control" placeholder="email@example.com" value="{{ old('email') }}" required>
                </div>

                <div class="form-group">
                    <label><i class="fas fa-tag"></i> SUBJEK</label>
                    <input type="text" name="subject" class="form-control" placeholder="Subjek pesan Anda" value="{{ old('subject') }}">
                </div>

                <div class="form-group">
                    <label><i class="fas fa-comment"></i> PESAN <span style="color: var(--primary);">*</span></label>
                    <textarea name="message" rows="5" class="form-control" placeholder="Tulis pesan Anda di sini..." required>{{ old('message') }}</textarea>
                </div>

                <div class="text-right">
                    <button type="submit" class="btn-nc-submit">
                        Kirim Pesan <i class="fas fa-paper-plane"></i>
                    </button>
                </div>
            </form>

            <div class="footer-note">
                <i class="fas fa-heart" style="color: var(--primary);"></i> Kami akan membalas pesan Anda dalam 1x24 jam kerja <i class="fas fa-heart" style="color: var(--primary);"></i>
            </div>
        </div>
    </div>
</div>

<script>
    // Auto hide flash message after 5 seconds
    setTimeout(function() {
        var success = document.getElementById('flash-success');
        var error = document.getElementById('flash-error');
        if (success) {
            success.style.opacity = '0';
            success.style.transition = 'opacity 0.5s';
            setTimeout(function() { if(success.parentNode) success.remove(); }, 500);
        }
        if (error) {
            error.style.opacity = '0';
            error.style.transition = 'opacity 0.5s';
            setTimeout(function() { if(error.parentNode) error.remove(); }, 500);
        }
    }, 5000);
</script>
@endsection