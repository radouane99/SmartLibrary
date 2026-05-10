<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Rappel de Retour</title>
</head>
<body style="margin:0; padding:0; background:#0f172a; font-family: 'Helvetica Neue', Arial, sans-serif;">
    <div style="max-width:600px; margin:30px auto; background:#1e293b; border-radius:16px; overflow:hidden; box-shadow: 0 20px 60px rgba(0,0,0,0.3);">
        
        {{-- HEADER --}}
        <div style="background: linear-gradient(135deg, #f59e0b, #d97706); padding:30px; text-align:center;">
            <div style="font-size:48px; margin-bottom:10px;">⏰</div>
            <h1 style="color:white; margin:0; font-size:22px; font-weight:800;">Rappel de Retour</h1>
            <p style="color:rgba(255,255,255,0.8); margin:5px 0 0; font-size:14px;">Votre emprunt arrive à échéance bientôt</p>
        </div>

        {{-- BODY --}}
        <div style="padding:30px;">
            <p style="color:#e2e8f0; font-size:15px; line-height:1.6;">
                Bonjour <strong style="color:#fbbf24;">{{ $emprunt->user->name }}</strong>,
            </p>
            
            <p style="color:#94a3b8; font-size:14px; line-height:1.6;">
                Nous vous rappelons que la date de retour de votre livre approche. 
                Merci de le retourner avant la date prévue.
            </p>

            {{-- LIVRE INFO --}}
            <div style="background:#334155; border-radius:12px; padding:20px; margin:20px 0; border-left: 4px solid #f59e0b;">
                <table style="width:100%;">
                    <tr>
                        <td style="color:#94a3b8; padding:4px 0; font-size:13px;">📖 Livre</td>
                        <td style="color:#f1f5f9; font-weight:700; text-align:right; font-size:14px;">{{ $emprunt->livre->titre }}</td>
                    </tr>
                    <tr>
                        <td style="color:#94a3b8; padding:4px 0; font-size:13px;">✍️ Auteur</td>
                        <td style="color:#f1f5f9; text-align:right; font-size:14px;">{{ $emprunt->livre->auteur }}</td>
                    </tr>
                    <tr>
                        <td style="color:#94a3b8; padding:4px 0; font-size:13px;">📅 Date d'emprunt</td>
                        <td style="color:#f1f5f9; text-align:right; font-size:14px;">{{ \Carbon\Carbon::parse($emprunt->dateEmp)->format('d/m/Y') }}</td>
                    </tr>
                    <tr>
                        <td style="color:#94a3b8; padding:4px 0; font-size:13px;">🔴 Date de retour</td>
                        <td style="color:#f87171; font-weight:800; text-align:right; font-size:14px;">{{ \Carbon\Carbon::parse($emprunt->dateRetour)->format('d/m/Y') }}</td>
                    </tr>
                </table>
            </div>

            <div style="text-align:center; margin-top:25px;">
                <div style="display:inline-block; background:#f59e0b; color:#0f172a; font-weight:800; padding:12px 32px; border-radius:30px; font-size:14px;">
                    ⚠️ Retour dans 2 jours
                </div>
            </div>

            <p style="color:#64748b; font-size:12px; text-align:center; margin-top:25px;">
                Si vous avez déjà retourné ce livre, veuillez ignorer ce message.
            </p>
        </div>

        {{-- FOOTER --}}
        <div style="background:#0f172a; padding:16px; text-align:center; border-top:1px solid #334155;">
            <p style="color:#475569; font-size:11px; margin:0;">
                📚 <span style="color:#60a5fa;">Gestion Bibliothèque</span> — Email automatique de rappel
            </p>
        </div>
    </div>
</body>
</html>
