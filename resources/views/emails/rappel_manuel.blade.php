<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rappel de retour d'ouvrage</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap');
        body {
            margin: 0 !important;
            padding: 0 !important;
            width: 100% !important;
            word-break: break-word;
            background-color: #fefce8;
            font-family: 'Inter', -apple-system, sans-serif;
        }
        table { border-collapse: collapse; }
        .wrapper { width: 100%; table-layout: fixed; background-color: #fefce8; padding-top: 40px; padding-bottom: 40px; }
        .main { width: 100%; max-width: 600px; background-color: #ffffff; border-radius: 24px; overflow: hidden; box-shadow: 0 10px 30px rgba(0,0,0,0.05); }
        .header { background: linear-gradient(135deg, #d97706 0%, #f59e0b 100%); padding: 50px 30px; text-align: center; }
        .header-icon { font-size: 60px; margin-bottom: 15px; display: block; }
        .header h1 { color: #ffffff; font-size: 28px; font-weight: 800; margin: 0; }
        .content { padding: 45px 35px; text-align: center; }
        .greeting { font-size: 24px; font-weight: 700; color: #0f172a; margin-bottom: 15px; }
        .text { font-size: 16px; line-height: 1.8; color: #475569; margin-bottom: 25px; }
        .info-card { background-color: #fffbeb; border-radius: 20px; padding: 30px; margin: 30px auto; border: 1px solid #fde68a; width: 85%; }
        .info-label { color: #92400e; font-weight: 500; font-size: 13px; text-transform: uppercase; letter-spacing: 1px; display: block; margin-bottom: 5px; }
        .info-value { color: #1e293b; font-weight: 700; font-size: 18px; display: block; }
        .badge { display: inline-block; background-color: #fffbeb; border: 1px solid #fde68a; border-radius: 50px; padding: 8px 20px; color: #92400e; font-size: 14px; font-weight: 700; margin-bottom: 20px; }
        .btn-container { padding: 35px 0; }
        .btn-primary { display: inline-block; background: #f59e0b; color: #ffffff !important; text-decoration: none; font-size: 16px; font-weight: 700; padding: 18px 45px; border-radius: 50px; }
        .footer { background-color: #fffbeb; padding: 30px; text-align: center; color: #92400e; font-size: 12px; border-top: 1px solid #fde68a; }
    </style>
</head>
<body>
    <center>
        <table class="wrapper" width="100%" cellpadding="0" cellspacing="0" border="0">
            <tr>
                <td align="center">
                    <table class="main" align="center" width="100%" cellpadding="0" cellspacing="0" border="0">
                        <tr>
                            <td class="header">
                                <span class="header-icon">🔔</span>
                                <h1>Rappel de retour</h1>
                            </td>
                        </tr>
                        <tr>
                            <td class="content">
                                <div class="badge">⏳ RETOUR ATTENDU</div>
                                <p class="greeting">Bonjour {{ $emprunt->user->name }},</p>
                                <p class="text">Ceci est un petit rappel amical pour le retour de votre ouvrage. D'autres lecteurs attendent peut-être de le découvrir !</p>
                                
                                <div class="info-card">
                                    <div style="margin-bottom: 15px;">
                                        <span class="info-label">Livre</span>
                                        <span class="info-value">"{{ $emprunt->livre->titre }}"</span>
                                    </div>
                                    <div style="margin-bottom: 15px;">
                                        <span class="info-label">Auteur</span>
                                        <span class="info-value">{{ $emprunt->livre->auteur }}</span>
                                    </div>
                                    <div>
                                        <span class="info-label">Date limite prévue</span>
                                        <span class="info-value" style="color: #d97706;">{{ \Carbon\Carbon::parse($emprunt->dateRetour)->format('d/m/Y') }}</span>
                                    </div>
                                </div>

                                <p class="text">Merci de rapporter le livre dès que possible au bureau de la bibliothèque.</p>

                                <div class="btn-container">
                                    <a href="{{ route('dashboard') }}" class="btn-primary">👤 Mon compte</a>
                                </div>

                                <p class="text" style="font-size: 14px; margin: 0;">Merci de votre coopération.<br><strong>L'équipe SmartLibrary</strong></p>
                            </td>
                        </tr>
                        <tr>
                            <td class="footer">
                                © {{ date('Y') }} SmartLibrary. Service de Rappel.<br>Merci de participer à la vie de la bibliothèque !
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
    </center>
</body>
</html>
