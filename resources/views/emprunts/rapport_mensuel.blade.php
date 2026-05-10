<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Rapport Mensuel - {{ $moisNom }} {{ $annee }}</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; color: #1e293b; font-size: 12px; line-height: 1.5; }

        .header {
            background: linear-gradient(135deg, #0f172a, #1e3a8a);
            color: white; padding: 30px 40px;
        }
        .header h1 { font-size: 24px; font-weight: 900; }
        .header .sub { color: #93c5fd; font-size: 12px; margin-top: 4px; }
        .header .period {
            float: right; background: rgba(255,255,255,0.1); padding: 10px 20px;
            border-radius: 8px; text-align: center;
        }
        .header .period .month { font-size: 18px; font-weight: 800; }
        .header .period .year { font-size: 11px; color: #93c5fd; }

        .stats-bar { display: table; width: 100%; background: #f8fafc; border-bottom: 2px solid #e2e8f0; }
        .stat-item { display: table-cell; text-align: center; padding: 16px; width: 20%; }
        .stat-item .number { font-size: 24px; font-weight: 900; }
        .stat-item .label { font-size: 10px; text-transform: uppercase; color: #64748b; font-weight: 700; letter-spacing: 1px; }
        .stat-item.primary .number { color: #2563eb; }
        .stat-item.success .number { color: #16a34a; }
        .stat-item.warning .number { color: #d97706; }
        .stat-item.info .number { color: #0891b2; }
        .stat-item.danger .number { color: #dc2626; }

        .body { padding: 30px 40px; }
        .section-title {
            font-size: 11px; font-weight: 800; text-transform: uppercase;
            letter-spacing: 1.5px; color: #2563eb; border-bottom: 2px solid #dbeafe;
            padding-bottom: 6px; margin: 20px 0 12px;
        }

        table.data { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        table.data th {
            background: #f1f5f9; padding: 8px 10px; font-size: 10px;
            text-transform: uppercase; color: #64748b; font-weight: 800;
            text-align: left; border-bottom: 2px solid #e2e8f0;
        }
        table.data td { padding: 7px 10px; border-bottom: 1px solid #f1f5f9; font-size: 11px; }
        table.data tr:nth-child(even) td { background: #fafbfc; }

        .badge { display: inline-block; padding: 2px 8px; border-radius: 12px; font-size: 10px; font-weight: 700; }
        .badge-valide { background: #dcfce7; color: #166534; }
        .badge-attente { background: #fef3c7; color: #92400e; }
        .badge-rendu { background: #dbeafe; color: #1e40af; }

        .footer {
            position: fixed; bottom: 0; left: 0; right: 0;
            background: #0f172a; color: #64748b; text-align: center;
            font-size: 9px; padding: 8px;
        }
        .footer span { color: #60a5fa; }
    </style>
</head>
<body>
    <div class="header">
        <div class="period">
            <div class="month">{{ $moisNom }}</div>
            <div class="year">{{ $annee }}</div>
        </div>
        <h1>📊 Rapport Mensuel</h1>
        <div class="sub">Gestion Bibliothèque — Généré le {{ now()->format('d/m/Y à H:i') }}</div>
    </div>

    <div class="stats-bar">
        <div class="stat-item primary">
            <div class="number">{{ $stats['total'] }}</div>
            <div class="label">Total Emprunts</div>
        </div>
        <div class="stat-item success">
            <div class="number">{{ $stats['valides'] }}</div>
            <div class="label">Validés</div>
        </div>
        <div class="stat-item warning">
            <div class="number">{{ $stats['en_attente'] }}</div>
            <div class="label">En Attente</div>
        </div>
        <div class="stat-item info">
            <div class="number">{{ $stats['rendus'] }}</div>
            <div class="label">Rendus</div>
        </div>
        <div class="stat-item danger">
            <div class="number">{{ $stats['retards'] }}</div>
            <div class="label">Retards</div>
        </div>
    </div>

    <div class="body">
        <div class="section-title">📋 Détails des Emprunts — {{ $moisNom }} {{ $annee }}</div>

        @if($emprunts->isEmpty())
            <p style="text-align:center; padding:30px; color:#94a3b8;">Aucun emprunt pour cette période.</p>
        @else
            <table class="data">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Livre</th>
                        <th>Auteur</th>
                        <th>Adhérent</th>
                        <th>Date Emprunt</th>
                        <th>Date Retour Prévue</th>
                        <th>Retour Effectif</th>
                        <th>Statut</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($emprunts as $emp)
                    <tr>
                        <td>{{ $emp->id }}</td>
                        <td><strong>{{ $emp->livre->titre ?? 'N/A' }}</strong></td>
                        <td>{{ $emp->livre->auteur ?? 'N/A' }}</td>
                        <td>{{ $emp->user->name ?? 'N/A' }}</td>
                        <td>{{ \Carbon\Carbon::parse($emp->dateEmp)->format('d/m/Y') }}</td>
                        <td>{{ \Carbon\Carbon::parse($emp->dateRetour)->format('d/m/Y') }}</td>
                        <td style="color: {{ $emp->dateRetourEffective ? '#16a34a' : '#94a3b8' }}">
                            {{ $emp->dateRetourEffective ? \Carbon\Carbon::parse($emp->dateRetourEffective)->format('d/m/Y') : '—' }}
                        </td>
                        <td>
                            @if($emp->statut === 'valide')
                                <span class="badge badge-valide">✅ Validé</span>
                            @elseif($emp->statut === 'en_attente')
                                <span class="badge badge-attente">⏳ Attente</span>
                            @else
                                <span class="badge badge-rendu">📚 Rendu</span>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        @endif

        <div style="margin-top:40px; text-align:center; border:1px dashed #e2e8f0; padding:16px; border-radius:8px;">
            <p style="font-size:11px; color:#94a3b8; margin:0;">
                Ce rapport a été généré automatiquement par le système Gestion Bibliothèque.
                Pour toute question, contactez l'administrateur de la bibliothèque.
            </p>
        </div>
    </div>

    <div class="footer">
        <span>Gestion Bibliothèque</span> — Rapport {{ $moisNom }} {{ $annee }} — Document confidentiel
    </div>
</body>
</html>
