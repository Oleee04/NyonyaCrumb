<!DOCTYPE html>
<html>
<head>
    <title>Pesan Kontak - Nyonya Crumb</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            font-family: 'Poppins', 'Segoe UI', system-ui, -apple-system, sans-serif;
            line-height: 1.5;
            color: #2D2A28;
            margin: 0;
            padding: 20px;
            background: #F7F2EA;
            background-image: radial-gradient(circle at 10% 20%, rgba(196, 122, 62, 0.03) 0%, transparent 50%);
        }

        .container {
            max-width: 580px;
            margin: 0 auto;
            background: #FFFFFF;
            border-radius: 32px;
            overflow: hidden;
            box-shadow: 0 20px 35px -12px rgba(0, 0, 0, 0.15), 0 0 0 1px rgba(196, 122, 62, 0.1);
            transition: transform 0.2s ease;
        }

        .header {
            background: linear-gradient(125deg, #B5651E 0%, #8B4513 100%);
            padding: 32px 28px;
            text-align: center;
            position: relative;
            overflow: hidden;
        }

        .header::before {
            content: "🍪";
            font-size: 120px;
            opacity: 0.08;
            position: absolute;
            bottom: -20px;
            right: -20px;
            pointer-events: none;
        }

        .header::after {
            content: "🧈";
            font-size: 90px;
            opacity: 0.07;
            position: absolute;
            top: -15px;
            left: -25px;
            pointer-events: none;
            transform: rotate(-15deg);
        }

        .logo-icon {
            font-size: 48px;
            margin-bottom: 8px;
            display: inline-block;
            filter: drop-shadow(0 4px 8px rgba(0,0,0,0.1));
        }

        .header h2 {
            margin: 0;
            font-size: 28px;
            font-weight: 600;
            letter-spacing: -0.3px;
            color: white;
            text-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        .header p {
            margin: 8px 0 0;
            font-size: 13px;
            font-weight: 400;
            color: rgba(255,255,240,0.9);
            letter-spacing: 0.3px;
        }

        .content {
            padding: 32px 30px;
            background: #ffffff;
        }

        .badge-wrapper {
            text-align: center;
            margin-bottom: 28px;
        }

        .badge {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: linear-gradient(110deg, #FEF5E8, #FEF0E0);
            color: #B5651E;
            font-size: 12px;
            font-weight: 600;
            padding: 6px 16px;
            border-radius: 60px;
            box-shadow: 0 2px 6px rgba(0,0,0,0.02);
            border: 1px solid rgba(196,122,62,0.25);
            backdrop-filter: blur(2px);
        }

        .field {
            margin-bottom: 24px;
        }

        .label {
            font-weight: 600;
            color: #A16234;
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 8px;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .value {
            font-size: 16px;
            font-weight: 500;
            color: #1F1C1A;
            word-wrap: break-word;
            background: #FEFAF5;
            padding: 10px 14px;
            border-radius: 20px;
            border: 1px solid #F3E8DD;
        }

        .message-box {
            background: #FEFAF5;
            padding: 20px;
            border-radius: 24px;
            border: 1px solid #F7EADF;
            margin-top: 4px;
            font-size: 15px;
            line-height: 1.65;
            color: #2F2A27;
            box-shadow: inset 0 1px 2px rgba(0,0,0,0.02), 0 1px 0 rgba(255,255,245,0.8);
        }

        .divider-custom {
            height: 2px;
            background: linear-gradient(90deg, transparent, #E9D9CD, #C47A3E, #E9D9CD, transparent);
            margin: 20px 0 16px;
            width: 100%;
        }

        .footer {
            background: #FCF8F3;
            text-align: center;
            padding: 20px 20px 22px;
            font-size: 11px;
            color: #B7A086;
            border-top: 1px solid #F2E6DC;
            font-weight: 400;
        }

        .footer p {
            margin: 4px 0;
        }

        .footer .signature {
            font-family: monospace;
            letter-spacing: 0.5px;
            font-size: 10px;
            color: #C8AD93;
        }

        a {
            color: #C47A3E;
            text-decoration: none;
            font-weight: 500;
            transition: all 0.2s;
            border-bottom: 1px dashed rgba(196,122,62,0.3);
        }

        a:hover {
            color: #9B541F;
            border-bottom-color: #C47A3E;
        }

        .value a {
            background: transparent;
            padding: 0;
            border-radius: 0;
        }

        @media (max-width: 550px) {
            .content {
                padding: 24px 20px;
            }
            .header {
                padding: 24px 20px;
            }
            .header h2 {
                font-size: 24px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <div class="logo-icon">🍪✨</div>
            <h2>Nyonya Crumb</h2>
            <p>Homemade Cookies · Authentic Taste</p>
        </div>

        <div class="content">
            <div class="badge-wrapper">
                <span class="badge">📩 ✦ PESAN MASUK ✦ 🧾</span>
            </div>

            <div class="field">
                <div class="label">👤  Nama lengkap</div>
                <div class="value">{{ $name }}</div>
            </div>

            <div class="field">
                <div class="label">📧  Alamat email</div>
                <div class="value">
                    <a href="mailto:{{ $email }}">{{ $email }}</a>
                </div>
            </div>

            <div class="field">
                <div class="label">📌  Subjek pesan</div>
                <div class="value">{{ $subject }}</div>
            </div>

            <div class="field">
                <div class="label">💬  Isi pesan</div>
                <div class="message-box">
                    {{ nl2br(e($messageContent)) }}
                </div>
            </div>

            <div class="divider-custom"></div>
            <div style="font-size: 12px; text-align: center; color: #BFAF9E;">
                ⏱️ Diterima &nbsp;•&nbsp; 🍪 Nyonya Crumb akan membalas dalam 1x24 jam
            </div>
        </div>

        <div class="footer">
            <p>📨  Dikirim melalui form kontak <strong>nyonyacrumb.com</strong></p>
            <p>© {{ date('Y') }} Nyonya Crumb — All rights reserved</p>
            <p class="signature">#RasakanKelembutanCookie</p>
        </div>
    </div>
</body>
</html>