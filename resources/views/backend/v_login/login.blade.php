<!DOCTYPE html> 
<html lang="id"> 
<head> 
    <meta charset="utf-8"> 
    <meta http-equiv="X-UA-Compatible" content="IE=edge"> 
    <meta name="viewport" content="width=device-width, initial-scale=1"> 
    <title>Backend Login - Nyonya Crumb</title> 
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('image/nyonyacrumb.jpeg') }}"> 
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Playfair+Display:wght@600;700&display=swap" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    
    <style>
        :root {
            --primary: #C47A3E;
            --primary-dark: #A05A2A;
            --bg-color: #0f172a;
            --card-bg: rgba(255, 255, 255, 0.05);
            --text-main: #f8fafc;
            --text-muted: #94a3b8;
            --input-bg: rgba(255, 255, 255, 0.05);
            --border-color: rgba(255, 255, 255, 0.1);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: var(--bg-color);
            background-image: 
                radial-gradient(circle at 15% 50%, rgba(196, 122, 62, 0.15), transparent 25%),
                radial-gradient(circle at 85% 30%, rgba(196, 122, 62, 0.1), transparent 25%);
            color: var(--text-main);
            overflow: hidden;
            position: relative;
        }

        /* Animated background elements */
        .blob {
            position: absolute;
            filter: blur(80px);
            z-index: 0;
            opacity: 0.6;
            animation: float 10s ease-in-out infinite alternate;
        }
        .blob-1 {
            width: 400px;
            height: 400px;
            background: rgba(196, 122, 62, 0.3);
            top: -100px;
            left: -100px;
            border-radius: 40% 60% 70% 30% / 40% 50% 60% 50%;
        }
        .blob-2 {
            width: 300px;
            height: 300px;
            background: rgba(160, 90, 42, 0.2);
            bottom: -50px;
            right: -50px;
            border-radius: 60% 40% 30% 70% / 60% 30% 70% 40%;
            animation-delay: -5s;
        }

        @keyframes float {
            0% { transform: translate(0, 0) rotate(0deg); }
            100% { transform: translate(30px, 50px) rotate(20deg); }
        }

        .login-container {
            width: 100%;
            max-width: 420px;
            padding: 40px;
            background: var(--card-bg);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid var(--border-color);
            border-radius: 24px;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
            z-index: 1;
            transform: translateY(20px);
            opacity: 0;
            animation: slideUp 0.6s cubic-bezier(0.16, 1, 0.3, 1) forwards;
        }

        @keyframes slideUp {
            to {
                transform: translateY(0);
                opacity: 1;
            }
        }

        .logo-container {
            text-align: center;
            margin-bottom: 32px;
        }

        .logo-container img {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid rgba(196, 122, 62, 0.5);
            padding: 4px;
            margin-bottom: 16px;
            box-shadow: 0 0 20px rgba(196, 122, 62, 0.3);
        }

        .title {
            font-family: 'Playfair Display', serif;
            font-size: 28px;
            font-weight: 700;
            margin-bottom: 8px;
            background: linear-gradient(to right, #fff, #ebd5c1);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .subtitle {
            font-size: 14px;
            color: var(--text-muted);
        }

        .form-group {
            margin-bottom: 24px;
            position: relative;
        }

        .form-group label {
            display: block;
            font-size: 13px;
            font-weight: 500;
            margin-bottom: 8px;
            color: #cbd5e1;
        }

        .input-icon {
            position: absolute;
            top: 38px;
            left: 16px;
            color: var(--text-muted);
            font-size: 14px;
            transition: color 0.3s;
        }

        .form-control {
            width: 100%;
            padding: 14px 16px 14px 44px;
            background: var(--input-bg);
            border: 1px solid var(--border-color);
            border-radius: 12px;
            color: white;
            font-size: 14px;
            font-family: 'Inter', sans-serif;
            transition: all 0.3s ease;
        }

        .form-control:focus {
            outline: none;
            border-color: var(--primary);
            background: rgba(255, 255, 255, 0.08);
            box-shadow: 0 0 0 4px rgba(196, 122, 62, 0.15);
        }

        .form-control:focus + .input-icon {
            color: var(--primary);
        }

        .form-control::placeholder {
            color: #64748b;
        }

        .btn-login {
            width: 100%;
            padding: 14px;
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
            border: none;
            border-radius: 12px;
            color: white;
            font-size: 15px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            margin-top: 10px;
            box-shadow: 0 10px 20px -10px rgba(196, 122, 62, 0.5);
        }

        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 15px 25px -10px rgba(196, 122, 62, 0.6);
        }

        .btn-login:active {
            transform: translateY(0);
        }

        .alert {
            padding: 14px;
            border-radius: 12px;
            margin-bottom: 24px;
            font-size: 13px;
            display: flex;
            align-items: center;
            gap: 10px;
            animation: shake 0.5s cubic-bezier(.36,.07,.19,.97) both;
        }

        @keyframes shake {
            10%, 90% { transform: translate3d(-1px, 0, 0); }
            20%, 80% { transform: translate3d(2px, 0, 0); }
            30%, 50%, 70% { transform: translate3d(-4px, 0, 0); }
            40%, 60% { transform: translate3d(4px, 0, 0); }
        }

        .alert-danger {
            background: rgba(239, 68, 68, 0.1);
            border: 1px solid rgba(239, 68, 68, 0.2);
            color: #fca5a5;
        }

        .invalid-feedback {
            display: block;
            color: #fca5a5;
            font-size: 12px;
            margin-top: 6px;
            margin-left: 4px;
        }

        .is-invalid {
            border-color: rgba(239, 68, 68, 0.5) !important;
        }
    </style>
</head> 
<body> 
    
    <div class="blob blob-1"></div>
    <div class="blob blob-2"></div>

    <div class="login-container">
        <div class="logo-container">
            <img src="{{ asset('image/nyonyacrumb.jpeg') }}" alt="Nyonya Crumb Logo">
            <h1 class="title">Welcome Back</h1>
            <p class="subtitle">Log in to Nyonya Crumb Admin Panel</p>
        </div>

        @if(session()->has('error')) 
        <div class="alert alert-danger"> 
            <i class="fas fa-exclamation-circle"></i>
            <span>{{ session('error')}}</span>
        </div> 
        @endif 

        <form action="{{ route('backend.login') }}" method="post"> 
            @csrf 
            <div class="form-group"> 
                <label for="email">Email Address</label>
                <i class="fas fa-envelope input-icon"></i>
                <input type="text" id="email" name="email" value="{{old('email')}}" class="form-control @error('email') is-invalid @enderror" placeholder="admin@nyonyacrumb.com"> 
                @error('email') 
                <span class="invalid-feedback"> 
                    {{$message}} 
                </span> 
                @enderror 
            </div> 

            <div class="form-group"> 
                <label for="password">Password</label>
                <i class="fas fa-lock input-icon"></i>
                <input type="password" id="password" name="password" class="form-control @error('password') is-invalid @enderror" placeholder="••••••••"> 
                @error('password') 
                <span class="invalid-feedback"> 
                    {{$message}}
                </span> 
                @enderror 
            </div> 

            <button type="submit" class="btn-login">
                Sign In <i class="fas fa-arrow-right" style="font-size: 12px; margin-left: 4px;"></i>
            </button>
        </form> 
    </div>

</body> 
</html>  
 