<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirmation de réservation - SmartLibrary</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap');
        body {
            margin: 0 !important;
            padding: 0 !important;
            width: 100% !important;
            word-break: break-word;
            background-color: #f1f5f9;
            font-family: 'Inter', -apple-system, sans-serif;
        }
        table { border-collapse: collapse; }
        .wrapper { width: 100%; table-layout: fixed; background-color: #f1f5f9; padding-top: 40px; padding-bottom: 40px; }
        .main { width: 100%; max-width: 600px; background-color: #ffffff; border-radius: 24px; overflow: hidden; box-shadow: 0 10px 30px rgba(0,0,0,0.05); }
        .header { background: linear-gradient(135deg, #0f172a 0%, #1e3a8a 100%); padding: 50px 30px; text-align: center; }
        .header-icon { font-size: 60px; margin-bottom: 15px; display: block; }
        .header h1 { color: #ffffff; font-size: 28px; font-weight: 800; margin: 0; }
        .header p { color: #93c5fd; font-size: 14px; margin-top: 6px; font-weight: 500; text-transform: uppercase; letter-spacing: 1px; }
        .content { padding: 45px 35px; text-align: center; }
        .greeting { font-size: 24px; font-weight: 700; color: #1e293b; margin-bottom: 15px; }
        .text { font-size: 16px; line-height: 1.8; color: #475569; margin-bottom: 25px; }
        .info-card { background-color: #f8fafc; border-radius: 20px; padding: 30px; margin: 30px auto; border: 1px solid #e2e8f0; width: 85%; }
        .info-label { color: #64748b; font-weight: 500; font-size: 13px; text-transform: uppercase; letter-spacing: 1px; display: block; margin-bottom: 5px; }
        .info-value { color: #1e293b; font-weight: 700; font-size: 18px; display: block; }
        .badge { display: inline-block; background-color: #f0fdf4; border: 1px solid #bbf7d0; border-radius: 50px; padding: 8px 20px; color: #166534; font-size: 14px; font-weight: 700; margin-bottom: 20px; }
        .btn-container { padding: 35px 0; }
        .btn-primary { display: inline-block; background: #2563eb; color: #ffffff !important; text-decoration: none; font-size: 16px; font-weight: 700; padding: 18px 45px; border-radius: 50px; }
        .footer { background-color: #f8fafc; padding: 30px; text-align: center; color: #94a3b8; font-size: 12px; border-top: 1px solid #e2e8f0; }
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
                                <span class="header-icon">🎉</span>
                                <h1>Réservation Confirmée</h1>
                                <p>📚 SmartLibrary</p>
                            </td>
                        </tr>
                        <tr>
                            <td class="content">
                                <div class="badge">✅ PRÊT À RÉCUPÉRER</div>
                                <p class="greeting">Félicitations, {{ $emprunt->user->name }} !</p>
                                <p class="text">Votre réservation a été validée par notre équipe. Vous pouvez passer à la bibliothèque pour récupérer votre ouvrage.</p>
                                
                                <div class="info-card">
                                    <div style="margin-bottom: 15px;">
                                        <span class="info-label">Livre</span>
                                        <span class="info-value">"{{ $emprunt->livre->titre }}"</span>
                                    </div>
                                    <div style="margin-bottom: 15px;">
                                        <span class="info-label">Date d'emprunt</span>
                                        <span class="info-value">{{ \Carbon\Carbon::parse($emprunt->dateEmp)->format('d/m/Y') }}</span>
                                    </div>
                                    <div>
                                        <span class="info-label">Date de retour prévue</span>
                                        <span class="info-value" style="color: #2563eb;">{{ \Carbon\Carbon::parse($emprunt->dateRetour)->format('d/m/Y') }}</span>
                                    </div>
                                </div>

                                <p class="text">N'oubliez pas de présenter votre code adhérent lors de votre passage.</p>

                                <div class="btn-container">
                                    <a href="{{ route('emprunts.index') }}" class="btn-primary">📖 Mes emprunts</a>
                                </div>

                                <p class="text" style="font-size: 14px; margin: 0;">Bonne lecture !<br><strong>L'équipe SmartLibrary</strong></p>
                            </td>
                        </tr>
                        <tr>
                            <td class="footer">
                                © {{ date('Y') }} SmartLibrary. Gestion de Bibliothèque.<br>Votre lecture, notre passion.
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
    </center>
</body>
</html>
