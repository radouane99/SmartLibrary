@extends('layouts._pageLayout')

@section('content')

<div class="container py-4">

    {{-- ✅ ALERTE DE SUCCÈS RÉSERVATION --}}
    @if(session('reservation_success'))
    @php $res = session('reservation_success'); @endphp
    <div class="alert-reservation mb-4" id="reservationAlert">
        <div class="alert-reservation-inner">
            <div class="alert-icon-wrap">
                <span class="alert-big-icon">🎉</span>
            </div>
            <div class="alert-content">
                <h5 class="alert-title">Réservation envoyée avec succès !</h5>
                <p class="alert-subtitle">Votre demande pour <strong>« {{ $res['livre'] }} »</strong> de {{ $res['auteur'] }} a été transmise à l'administrateur.</p>
                <div class="alert-details">
                    <span>📅 Date de retour prévue : <strong>{{ \Carbon\Carbon::parse($res['date_retour'])->format('d/m/Y') }}</strong></span>
                    <span>⏳ Statut : <span class="badge-pending">En attente de validation</span></span>
                </div>
                <p class="alert-note">📍 Passez à la bibliothèque pour récupérer votre livre une fois validé.</p>
            </div>
            <button onclick="document.getElementById('reservationAlert').style.display='none'" class="alert-close">✕</button>
        </div>
    </div>
    <style>
        .alert-reservation {
            background: linear-gradient(135deg, #f0fdf4, #dcfce7);
            border: 1px solid #86efac;
            border-left: 5px solid #16a34a;
            border-radius: 20px;
            padding: 24px;
            animation: slideDown 0.5s ease;
        }
        @keyframes slideDown {
            from { opacity: 0; transform: translateY(-20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .alert-reservation-inner { display: flex; align-items: flex-start; gap: 20px; }
        .alert-big-icon { font-size: 48px; line-height: 1; flex-shrink: 0; }
        .alert-content { flex: 1; }
        .alert-title { font-size: 20px; font-weight: 800; color: #14532d; margin-bottom: 6px; }
        .alert-subtitle { font-size: 15px; color: #166534; margin-bottom: 12px; }
        .alert-details { display: flex; flex-wrap: wrap; gap: 16px; font-size: 14px; color: #15803d; margin-bottom: 10px; }
        .badge-pending { background: #fef3c7; color: #92400e; padding: 2px 10px; border-radius: 20px; font-size: 12px; font-weight: 700; }
        .alert-note { font-size: 13px; color: #4ade80; background: rgba(0,0,0,0.05); padding: 8px 12px; border-radius: 10px; margin: 0; }
        .alert-close { background: none; border: none; font-size: 18px; color: #16a34a; cursor: pointer; flex-shrink: 0; padding: 4px 8px; border-radius: 8px; transition: background 0.2s; }
        .alert-close:hover { background: rgba(22,163,74,0.1); }
    </style>
    @endif

    <div class="d-flex align-items-center justify-content-between mb-4">
        <div>
            <h1 class="fw-bold mb-1">📊 Dashboard</h1>
            <p class="text-muted mb-0">Ravi de vous revoir, <span class="text-primary fw-bold">{{ $user->name }}</span>.</p>
        </div>
        <div class="d-flex gap-2">
            <span class="badge bg-light text-dark border px-3 py-2 rounded-pill shadow-sm">
                <i class="bi bi-calendar3 me-1"></i> {{ now()->format('d M Y') }}
            </span>
        </div>
    </div>

    <div class="row g-4">
        {{-- COLONNE GAUCHE : STATS ET GRAPHIQUES --}}
        <div class="col-lg-8">
            
            {{-- STATS GRID --}}
            <div class="row g-3 mb-4">
                @php
                    $stats = $user->role === 'admin' ? [
                        ['label' => 'Livres', 'val' => $totalLivres, 'icon' => 'bi-book-fill', 'color' => 'primary'],
                        ['label' => 'Adhérents', 'val' => $totalAdherents, 'icon' => 'bi-people-fill', 'color' => 'info'],
                        ['label' => 'Emprunts', 'val' => $totalEmprunts, 'icon' => 'bi-arrow-left-right', 'color' => 'warning'],
                        ['label' => 'Retards', 'val' => $empruntsEnRetard, 'icon' => 'bi-exclamation-triangle-fill', 'color' => 'danger'],
                    ] : [
                        ['label' => 'Livres Lus', 'val' => $totalMesLivresLus, 'icon' => 'bi-check-all', 'color' => 'success'],
                        ['label' => 'En Cours', 'val' => $mesEmprunts->count(), 'icon' => 'bi-journal-bookmark-fill', 'color' => 'primary'],
                        ['label' => 'Catalogue', 'val' => $totalLivres, 'icon' => 'bi-collection-fill', 'color' => 'info'],
                        ['label' => 'Retards', 'val' => $mesEmpruntsRetard, 'icon' => 'bi-clock-history', 'color' => 'danger'],
                    ];
                @endphp

                @foreach($stats as $s)
                <div class="col-md-3">
                    <div class="premium-card p-3 h-100 border-0 shadow-sm rounded-4">
                        <div class="d-flex align-items-center gap-3">
                            <div class="stat-icon bg-{{ $s['color'] }} bg-opacity-10 text-{{ $s['color'] }} rounded-3 p-3">
                                <i class="bi {{ $s['icon'] }} fs-3"></i>
                            </div>
                            <div>
                                <h3 class="fw-bold mb-0">{{ $s['val'] }}</h3>
                                <small class="text-muted text-uppercase fw-bold" style="font-size: 0.65rem;">{{ $s['label'] }}</small>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            {{-- CHART CARD --}}
            <div class="premium-card mb-4 border-0 shadow-sm rounded-4 overflow-hidden">
                <div class="card-header bg-white border-0 pt-4 px-4 d-flex justify-content-between align-items-center">
                    <h5 class="fw-bold mb-0">📈 Popularité par Thème</h5>
                    <span class="badge bg-light text-muted border">Global</span>
                </div>
                <div class="card-body px-4 pb-4">
                    <canvas id="themeChart" style="max-height: 300px;"></canvas>
                </div>
            </div>

            {{-- TABLEAU RÉCENT (ADMIN OU ADHÉRENT) --}}
            <div class="premium-card border-0 shadow-sm rounded-4 overflow-hidden">
                <div class="card-header bg-white border-0 pt-4 px-4 d-flex justify-content-between align-items-center">
                    <h5 class="fw-bold mb-0">🕒 {{ $user->role === 'admin' ? 'Derniers Emprunts' : 'Mes Activités' }}</h5>
                    <a href="{{ route('emprunts.index') }}" class="btn btn-sm btn-light border small">Voir tout</a>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table align-middle table-hover mb-0">
                            <thead class="table-light">
                                <tr class="small text-uppercase text-muted">
                                    <th class="px-4">Livre</th>
                                    <th>{{ $user->role === 'admin' ? 'Adhérent' : 'Date Emprunt' }}</th>
                                    <th>Retour</th>
                                    <th class="text-end px-4">Statut</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $list = $user->role === 'admin' ? $derniersEmprunts : $mesEmprunts; @endphp
                                @forelse($list as $emp)
                                <tr>
                                    <td class="px-4">
                                        <div class="fw-bold">{{ $emp->livre->titre ?? '—' }}</div>
                                        <small class="text-muted">{{ $emp->livre->auteur ?? '—' }}</small>
                                    </td>
                                    <td>{{ $user->role === 'admin' ? ($emp->user->name ?? '—') : $emp->dateEmp }}</td>
                                    <td>
                                        <span class="{{ \Carbon\Carbon::parse($emp->dateRetour)->isPast() ? 'text-danger fw-bold' : '' }}">
                                            {{ $emp->dateRetour }}
                                        </span>
                                    </td>
                                    <td class="text-end px-4">
                                        @if($emp->statut === 'en_attente')
                                            <span class="badge bg-warning-subtle text-warning border border-warning px-2 py-1 rounded-pill">Attente</span>
                                        @elseif($emp->statut === 'valide')
                                            <span class="badge bg-success-subtle text-success border border-success px-2 py-1 rounded-pill">Validé</span>
                                        @elseif($emp->statut === 'refuse')
                                            <span class="badge bg-danger-subtle text-danger border border-danger px-2 py-1 rounded-pill">Refusé</span>
                                        @else
                                            <span class="badge bg-secondary-subtle text-secondary border border-secondary px-2 py-1 rounded-pill">Rendu</span>
                                        @endif
                                    </td>
                                </tr>
                                @empty
                                <tr><td colspan="4" class="text-center py-4 text-muted">Aucune activité récente.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        {{-- COLONNE DROITE : NOTIFICATIONS ET RECOMMANDATIONS --}}
        <div class="col-lg-4">
            
            {{-- NOTIFICATIONS PANEL --}}
            <div class="premium-card mb-4 border-0 shadow-sm rounded-4 overflow-hidden">
                <div class="card-header bg-white border-0 pt-4 px-4 d-flex align-items-center justify-content-between">
                    <h5 class="fw-bold mb-0">🔔 Notifications</h5>
                    @if($unreadCount > 0)
                        <span class="badge bg-danger rounded-pill">{{ $unreadCount }}</span>
                    @endif
                </div>
                <div class="card-body p-0">
                    <div class="list-group list-group-flush">
                        @forelse($recentNotifications as $notif)
                        <div class="list-group-item border-0 border-bottom px-4 py-3 {{ $notif->is_read ? 'opacity-75' : 'bg-light bg-opacity-25' }}">
                            <div class="d-flex gap-3">
                                <div class="text-{{ $notif->type }} mt-1">
                                    <i class="bi bi-{{ $notif->type === 'success' ? 'check-circle-fill' : 'info-circle-fill' }}"></i>
                                </div>
                                <div>
                                    <div class="small fw-bold">{{ $notif->message }}</div>
                                    <small class="text-muted" style="font-size: 0.7rem;">{{ $notif->created_at->diffForHumans() }}</small>
                                </div>
                            </div>
                        </div>
                        @empty
                        <div class="p-4 text-center text-muted small">Aucune notification.</div>
                        @endforelse
                    </div>
                </div>
            </div>

            {{-- RECOMMANDATIONS (ADHÉRENT) / RACCOURCIS (ADMIN) --}}
            @if($user->role === 'admin')
                <div class="premium-card border-0 shadow-sm rounded-4 p-4 mb-4">
                    <h5 class="fw-bold mb-3">⚡ Actions Rapides</h5>
                    <div class="d-grid gap-2">
                        <a href="{{ route('livres.create') }}" class="btn btn-primary btn-custom text-start px-3 py-2">
                            <i class="bi bi-plus-lg me-2"></i> Nouveau Livre
                        </a>
                        <a href="{{ route('adherents.create') }}" class="btn btn-light border btn-custom text-start px-3 py-2">
                            <i class="bi bi-person-plus me-2"></i> Ajouter Adhérent
                        </a>
                        <a href="{{ route('emprunts.create') }}" class="btn btn-light border btn-custom text-start px-3 py-2">
                            <i class="bi bi-bookmark-plus me-2"></i> Créer Emprunt
                        </a>
                    </div>
                </div>

                {{-- OUTILS ADMIN --}}
                <div class="premium-card border-0 shadow-sm rounded-4 p-4">
                    <h5 class="fw-bold mb-3">📊 Outils Admin</h5>
                    <div class="d-grid gap-2">
                        <a href="{{ route('admin.retards') }}" class="btn btn-outline-danger btn-custom text-start px-3 py-2">
                            <i class="bi bi-exclamation-triangle me-2"></i> Retards 
                            @if($empruntsEnRetard > 0)
                                <span class="badge bg-danger float-end">{{ $empruntsEnRetard }}</span>
                            @endif
                        </a>
                        <a href="{{ route('emprunts.export') }}" class="btn btn-outline-success btn-custom text-start px-3 py-2">
                            <i class="bi bi-file-earmark-spreadsheet me-2"></i> Export CSV
                        </a>
                        <a href="{{ route('admin.rapport') }}" class="btn btn-outline-primary btn-custom text-start px-3 py-2">
                            <i class="bi bi-file-earmark-pdf me-2"></i> Rapport Mensuel
                        </a>
                    </div>
                </div>
            @else
                <div class="premium-card bg-dark text-white border-0 shadow rounded-4 p-4 position-relative overflow-hidden">
                    <div class="position-absolute top-0 end-0 opacity-10 p-3"><i class="bi bi-stars fs-1"></i></div>
                    <h5 class="fw-bold mb-4">✨ Pour vous</h5>
                    @foreach($suggestions as $suggest)
                    <div class="d-flex align-items-center gap-3 mb-3">
                        <div class="bg-white bg-opacity-10 rounded p-2 text-white"><i class="bi bi-lightning-fill"></i></div>
                        <div class="overflow-hidden">
                            <div class="fw-bold text-truncate small">{{ $suggest->titre }}</div>
                            <small class="text-white-50" style="font-size: 0.7rem;">{{ $suggest->theme->intitule }}</small>
                        </div>
                        <a href="{{ route('livres.show', $suggest->id) }}" class="ms-auto btn btn-sm btn-outline-light rounded-circle p-1"><i class="bi bi-arrow-right"></i></a>
                    </div>
                    @endforeach
                    <a href="{{ route('livres.index') }}" class="btn btn-primary btn-sm w-100 mt-2">Découvrir plus</a>
                </div>
            @endif

        </div>
    </div>

</div>

{{-- SCRIPTS POUR LES GRAPHIQUES --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const ctx = document.getElementById('themeChart').getContext('2d');
        const chartData = @json($chartData);
        
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: chartData.map(d => d.theme),
                datasets: [{
                    label: 'Nombre d\'emprunts',
                    data: chartData.map(d => d.count),
                    backgroundColor: 'rgba(37, 99, 235, 0.2)',
                    borderColor: 'rgba(37, 99, 235, 1)',
                    borderWidth: 2,
                    borderRadius: 8,
                    hoverBackgroundColor: 'rgba(37, 99, 235, 0.4)',
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false }
                },
                scales: {
                    y: { 
                        beginAtZero: true,
                        grid: { display: false },
                        ticks: { stepSize: 1 }
                    },
                    x: { grid: { display: false } }
                }
            }
        });
    });
</script>

<style>
    .stat-icon { width: 54px; height: 54px; display: flex; align-items: center; justify-content: center; }
    .premium-card { background: white; transition: transform 0.3s ease; }
    .premium-card:hover { transform: translateY(-3px); }
</style>

@endsection
