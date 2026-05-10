<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Reçu d'Emprunt #{{ str_pad($emprunt->id, 6, '0', STR_PAD_LEFT) }}</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; color: #1e293b; font-size: 13px; line-height: 1.6; }

        /* ── HEADER ─────────────────────────── */
        .header {
            background: linear-gradient(135deg, #0f172a 0%, #1e3a8a 100%);
            color: white;
            padding: 30px 40px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .brand-name { font-size: 26px; font-weight: 900; letter-spacing: -0.5px; }
        .brand-sub { font-size: 11px; color: #93c5fd; text-transform: uppercase; letter-spacing: 1px; margin-top: 3px; }
        .doc-ref { text-align: right; }
        .doc-ref .ref-number { font-size: 22px; font-weight: 800; color: #60a5fa; }
        .doc-ref .ref-label { font-size: 11px; color: #94a3b8; text-transform: uppercase; }

        /* ── STATUS BANNER ───────────────────── */
        .status-banner {
            padding: 12px 40px;
            font-size: 13px;
            font-weight: 700;
            text-align: center;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        .status-valide { background: #dcfce7; color: #166534; border-bottom: 2px solid #86efac; }
        .status-rendu  { background: #dbeafe; color: #1e40af; border-bottom: 2px solid #93c5fd; }
        .status-attente { background: #fef3c7; color: #92400e; border-bottom: 2px solid #fde68a; }

        /* ── BODY ────────────────────────────── */
        .body { padding: 35px 40px; }

        .section { margin-bottom: 28px; }
        .section-title {
            font-size: 11px;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            color: #2563eb;
            padding-bottom: 6px;
            border-bottom: 2px solid #dbeafe;
            margin-bottom: 14px;
        }

        /* ── INFO GRID ───────────────────────── */
        .info-grid { width: 100%; border-collapse: collapse; }
        .info-grid tr:nth-child(even) td { background: #f8fafc; }
        .info-grid td { padding: 9px 12px; vertical-align: top; }
        .info-grid .label { color: #64748b; font-weight: 600; width: 45%; font-size: 12px; }
        .info-grid .value { font-weight: 700; color: #0f172a; font-size: 13px; }
        .info-grid .value.danger { color: #dc2626; }
        .info-grid .value.success { color: #16a34a; }

        /* ── TWO COLUMNS ─────────────────────── */
        .two-col { display: table; width: 100%; margin-bottom: 28px; }
        .col-half { display: table-cell; width: 48%; vertical-align: top; }
        .col-half:first-child { padding-right: 2%; }

        /* ── BADGE ───────────────────────────── */
        .badge { display: inline-block; padding: 4px 12px; border-radius: 20px; font-size: 11px; font-weight: 800; text-transform: uppercase; }
        .badge-valide   { background: #dcfce7; color: #166534; }
        .badge-rendu    { background: #dbeafe; color: #1e40af; }
        .badge-attente  { background: #fef3c7; color: #92400e; }

        /* ── DIVIDER ─────────────────────────── */
        .divider { border: none; border-top: 1px dashed #e2e8f0; margin: 20px 0; }

        /* ── NOTICE BOX ──────────────────────── */
        .notice {
            background: #fffbeb;
            border: 1px solid #fde68a;
            border-left: 4px solid #f59e0b;
            border-radius: 6px;
            padding: 12px 16px;
            font-size: 12px;
            color: #92400e;
            margin-bottom: 24px;
        }

        /* ── SIGNATURE ───────────────────────── */
        .signature-area { margin-top: 50px; display: table; width: 100%; }
        .sig-box { display: table-cell; width: 50%; text-align: center; }
        .sig-line { border-top: 1px solid #cbd5e1; margin: 0 20px; padding-top: 8px; font-size: 11px; color: #64748b; }

        /* ── FOOTER ──────────────────────────── */
        .footer {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            background: #0f172a;
            color: #475569;
            text-align: center;
            font-size: 10px;
            padding: 10px 40px;
        }
        .footer span { color: #60a5fa; }
    </style>
</head>
<body>

    {{-- HEADER --}}
    <div class="header">
        <div>
            <div class="brand-name">📚 Gestion Bibliothèque</div>
            <div class="brand-sub">Système de Gestion de Bibliothèque</div>
        </div>
        <div class="doc-ref">
            <div class="ref-label">Référence du document</div>
            <div class="ref-number">EMP-{{ str_pad($emprunt->id, 6, '0', STR_PAD_LEFT) }}</div>
            <div style="font-size: 11px; color: #94a3b8; margin-top: 4px;">Émis le {{ now()->format('d/m/Y à H:i') }}</div>
        </div>
    </div>

    {{-- STATUS BANNER --}}
    @php
        $statutClass = $emprunt->statut === 'valide' ? 'valide' : ($emprunt->statut === 'rendu' ? 'rendu' : 'attente');
        $statutLabel = $emprunt->statut === 'valide' ? '✅ Emprunt Actif et Validé'
                    : ($emprunt->statut === 'rendu' ? '📚 Livre Retourné — Emprunt Clôturé' : '⏳ En Attente de Validation');
    @endphp
    <div class="status-banner status-{{ $statutClass }}">{{ $statutLabel }}</div>

    <div class="body">

        {{-- DEUX COLONNES : ADHÉRENT + LIVRE --}}
        <div class="two-col">
            <div class="col-half">
                <div class="section-title">👤 Informations Adhérent</div>
                <table class="info-grid">
                    <tr>
                        <td class="label">Nom complet</td>
                        <td class="value">{{ $emprunt->user->name }}</td>
                    </tr>
                    <tr>
                        <td class="label">Email</td>
                        <td class="value">{{ $emprunt->user->email }}</td>
                    </tr>
                    <tr>
                        <td class="label">Code Adhérent</td>
                        <td class="value">{{ $emprunt->user->codeA ?? 'N/A' }}</td>
                    </tr>
                    <tr>
                        <td class="label">Statut</td>
                        <td class="value"><span class="badge badge-valide">Actif</span></td>
                    </tr>
                </table>
            </div>
            <div class="col-half">
                <div class="section-title">📖 Détails du Livre</div>
                <table class="info-grid">
                    <tr>
                        <td class="label">Titre</td>
                        <td class="value">{{ $emprunt->livre->titre }}</td>
                    </tr>
                    <tr>
                        <td class="label">Auteur</td>
                        <td class="value">{{ $emprunt->livre->auteur }}</td>
                    </tr>
                    <tr>
                        <td class="label">Catégorie</td>
                        <td class="value">{{ $emprunt->livre->theme->intitule ?? 'N/A' }}</td>
                    </tr>
                    <tr>
                        <td class="label">Disponibilité</td>
                        <td class="value success">{{ $emprunt->livre->nbExemplaire }} exemplaire(s)</td>
                    </tr>
                </table>
            </div>
        </div>

        {{-- DATES --}}
        <div class="section">
            <div class="section-title">📅 Période d'Emprunt</div>
            <table class="info-grid">
                <tr>
                    <td class="label">Date d'emprunt</td>
                    <td class="value">{{ \Carbon\Carbon::parse($emprunt->dateEmp)->format('d/m/Y') }}</td>
                </tr>
                <tr>
                    <td class="label">Date de retour prévue</td>
                    <td class="value danger">{{ \Carbon\Carbon::parse($emprunt->dateRetour)->format('d/m/Y') }}</td>
                </tr>
                @if($emprunt->dateRetourEffective)
                <tr>
                    <td class="label">Date de retour effective</td>
                    <td class="value success">{{ \Carbon\Carbon::parse($emprunt->dateRetourEffective)->format('d/m/Y') }}</td>
                </tr>
                @endif
                <tr>
                    <td class="label">Durée de l'emprunt</td>
                    <td class="value">{{ \Carbon\Carbon::parse($emprunt->dateEmp)->diffInDays(\Carbon\Carbon::parse($emprunt->dateRetour)) }} jours</td>
                </tr>
            </table>
        </div>

        {{-- NOTICE --}}
        <div class="notice">
            ⚠️ <strong>Important :</strong> Ce document atteste de la possession temporaire de l'ouvrage mentionné.
            Veuillez retourner le livre avant la date prévue. Tout retard sera signalé à l'administration.
        </div>

        {{-- SIGNATURES --}}
        <div class="signature-area">
            <div class="sig-box">
                <div class="sig-line">Signature de l'Adhérent</div>
            </div>
            <div class="sig-box">
                <div class="sig-line">Cachet & Signature Bibliothèque</div>
            </div>
        </div>

    </div>

    {{-- FOOTER --}}
    <div class="footer">
        <span>Gestion Bibliothèque</span> — Système de Gestion de Bibliothèque — Document généré le {{ now()->format('d/m/Y à H:i') }} — EMP-{{ str_pad($emprunt->id, 6, '0', STR_PAD_LEFT) }}
    </div>

</body>
</html>
