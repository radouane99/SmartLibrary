<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Réinitialisation de mot de passe - SmartLibrary</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap');
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
            background-color: #f1f5f9;
            color: #334155;
            padding: 40px 20px;
        }
        .wrapper { max-width: 600px; margin: 0 auto; box-shadow: 0 10px 30px rgba(0,0,0,0.05); border-radius: 24px; overflow: hidden; }
        .header {
            background: linear-gradient(135deg, #0f172a 0%, #1e3a8a 100%);
            padding: 50px 30px;
            text-align: center;
        }
        .header-icon { font-size: 60px; margin-bottom: 15px; display: block; }
        .header h1 { color: #ffffff; font-size: 28px; font-weight: 800; letter-spacing: -0.5px; }
        .header p { color: #93c5fd; font-size: 14px; margin-top: 6px; font-weight: 500; text-transform: uppercase; letter-spacing: 1px; }
        
        .email-body {
            background: #ffffff;
            padding: 45px 35px;
            text-align: center;
        }
        .greeting { font-size: 24px; font-weight: 700; color: #1e293b; margin-bottom: 15px; }
        .text { font-size: 16px; line-height: 1.8; color: #475569; margin-bottom: 25px; }
        
        .alert-box {
            background: #eff6ff;
            border: 1px solid #bfdbfe;
            border-radius: 16px;
            padding: 20px;
            margin: 30px auto;
            max-width: 90%;
        }
        .alert-icon { font-size: 24px; display: block; margin-bottom: 8px; }
        .alert-text { font-size: 14px; color: #1e40af; line-height: 1.6; }
        
        .btn-container { text-align: center; margin: 35px 0; }
        .btn-reset {
            display: inline-block;
            background: linear-gradient(135deg, #1d4ed8, #7c3aed);
            color: #ffffff !important;
            text-decoration: none;
            font-size: 16px;
            font-weight: 700;
            padding: 18px 45px;
            border-radius: 50px;
            box-shadow: 0 10px 25px rgba(37, 99, 235, 0.4);
        }

        .fallback {
            background: #f8fafc;
            border-radius: 12px;
            padding: 20px;
            margin-top: 30px;
            text-align: center;
        }
        .fallback p { font-size: 13px; color: #64748b; margin-bottom: 10px; }
        .fallback .link { font-size: 11px; color: #2563eb; word-break: break-all; opacity: 0.8; }

        .footer {
            background: #f8fafc;
            padding: 30px;
            text-align: center;
            color: #94a3b8;
            font-size: 12px;
            border-top: 1px solid #e2e8f0;
        }
    </style>
</head>
<body>
<div class="wrapper">
    <div class="header">
        <span class="header-icon">🔐</span>
        <h1>Récupération</h1>
        <p>📚 SmartLibrary</p>
    </div>

    <div class="email-body">
        <p class="greeting">Besoin d'un nouveau mot de passe ?</p>
        <p class="text">
            Nous avons reçu une demande de réinitialisation pour votre compte. Si c'est bien vous, cliquez sur le bouton ci-dessous.
        </p>

        <div class="alert-box">
            <span class="alert-icon">⏱️</span>
            <div class="alert-text">
                <strong>Lien temporaire</strong><br>
                Ce lien expirera dans 60 minutes pour votre sécurité.
            </div>
        </div>

        <div class="btn-container">
            <a href="{{ route('password.reset', ['token' => $token, 'email' => $email]) }}" class="btn-reset">
                🔑 &nbsp; Réinitialiser mon mot de passe
            </a>
        </div>

        <div class="fallback">
            <p>Si le bouton ne fonctionne pas, copiez ce lien :</p>
            <span class="link">{{ route('password.reset', ['token' => $token, 'email' => $email]) }}</span>
        </div>
    </div>

    <div class="footer">
        © {{ date('Y') }} SmartLibrary. Système de Sécurité.<br>
        Si vous n'avez pas demandé ce changement, ignorez cet email.
    </div>
</div>
</body>
</html>
