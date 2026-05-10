<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nouvelle Réservation - SmartLibrary</title>
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
            background: linear-gradient(135deg, #1e293b 0%, #334155 100%);
            padding: 50px 30px;
            text-align: center;
        }
        .header-icon { font-size: 60px; margin-bottom: 15px; display: block; }
        .header h1 { color: #ffffff; font-size: 28px; font-weight: 800; letter-spacing: -0.5px; }
        .header p { color: #94a3b8; font-size: 14px; margin-top: 6px; font-weight: 500; text-transform: uppercase; letter-spacing: 1px; }
        
        .email-body {
            background: #ffffff;
            padding: 45px 35px;
            text-align: center;
        }
        .greeting { font-size: 24px; font-weight: 700; color: #1e293b; margin-bottom: 15px; }
        .text { font-size: 16px; line-height: 1.8; color: #475569; margin-bottom: 25px; }
        
        .info-card {
            background: #f8fafc;
            border-radius: 20px;
            padding: 30px;
            margin: 30px auto;
            border: 1px solid #e2e8f0;
            max-width: 90%;
        }
        .info-row { margin-bottom: 12px; }
        .info-label { color: #64748b; font-weight: 500; font-size: 13px; text-transform: uppercase; letter-spacing: 1px; display: block; margin-bottom: 4px; }
        .info-value { color: #1e293b; font-weight: 700; font-size: 16px; display: block; }
        
        .badge-admin {
            display: inline-block;
            background-color: #f1f5f9;
            border: 1px solid #e2e8f0;
            border-radius: 50px;
            padding: 8px 20px;
            color: #475569;
            font-size: 14px;
            font-weight: 700;
            margin-bottom: 20px;
        }

        .btn-container { text-align: center; margin: 35px 0; }
        .btn-primary {
            display: inline-block;
            background: linear-gradient(135deg, #1e293b, #0f172a);
            color: #ffffff !important;
            text-decoration: none;
            font-size: 16px;
            font-weight: 700;
            padding: 18px 45px;
            border-radius: 50px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.1);
        }

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
        <span class="header-icon">📥</span>
        <h1>Nouvelle Demande</h1>
        <p>📚 Panel Admin</p>
    </div>

    <div class="email-body">
        <div class="badge-admin">🔔 ACTION REQUISE</div>

        <p class="greeting">Bonjour Administrateur,</p>
        <p class="text">
            Un adhérent vient de soumettre une nouvelle demande de réservation. Veuillez la traiter depuis votre tableau de bord.
        </p>

        <div class="info-card">
            <div class="info-row">
                <span class="info-label">Adhérent</span>
                <span class="info-value">{{ $emprunt->user->name }}</span>
            </div>
            <div class="info-row">
                <span class="info-label">Livre</span>
                <span class="info-value">"{{ $emprunt->livre->titre }}"</span>
            </div>
            <div class="info-row" style="margin-bottom: 0;">
                <span class="info-label">Date prévue</span>
                <span class="info-value">{{ \Carbon\Carbon::parse($emprunt->dateEmp)->format('d/m/Y') }}</span>
            </div>
        </div>

        <div class="btn-container">
            <a href="{{ route('emprunts.index') }}" class="btn-primary">
                ⚙️ Gérer les emprunts
            </a>
        </div>
    </div>

    <div class="footer">
        © {{ date('Y') }} SmartLibrary. Notification Système.
    </div>
</div>
</body>
</html>
