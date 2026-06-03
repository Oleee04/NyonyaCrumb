<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Kode OTP Anda</title>
    <style>
        body {
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            background-color: #FDF9F5;
            color: #3E2723;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 600px;
            margin: 40px auto;
            background: #FFFFFF;
            padding: 40px;
            border-radius: 8px;
            border: 1px solid rgba(139, 94, 60, 0.12);
            text-align: center;
        }
        .logo {
            font-size: 24px;
            font-family: Georgia, serif;
            color: #8D6E63;
            font-weight: bold;
            margin-bottom: 20px;
        }
        h2 {
            color: #3E2723;
            margin-bottom: 20px;
        }
        p {
            font-size: 16px;
            line-height: 1.5;
            color: #555;
            margin-bottom: 30px;
        }
        .otp-code {
            font-size: 32px;
            font-weight: bold;
            letter-spacing: 5px;
            color: #8D6E63;
            background: #FDF9F5;
            padding: 15px 30px;
            border-radius: 6px;
            display: inline-block;
            margin-bottom: 30px;
            border: 1px dashed #C6A68A;
        }
        .footer {
            margin-top: 40px;
            font-size: 12px;
            color: #888;
            border-top: 1px solid #EEE;
            padding-top: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="logo">Nyonya Crumb</div>
        <h2>Reset Password Anda</h2>
        <p>Halo,<br><br>Kami menerima permintaan untuk mereset password akun Nyonya Crumb Anda. Gunakan kode OTP berikut untuk melanjutkan proses reset password. Kode ini hanya berlaku selama 15 menit.</p>
        
        <div class="otp-code">
            {{ $otp }}
        </div>
        
        <p>Jika Anda tidak pernah meminta reset password, silakan abaikan email ini. Keamanan akun Anda tetap terjamin.</p>
        
        <div class="footer">
            &copy; {{ date('Y') }} Nyonya Crumb. Hak Cipta Dilindungi.<br>
            Email ini dikirim secara otomatis, mohon tidak membalas email ini.
        </div>
    </div>
</body>
</html>
