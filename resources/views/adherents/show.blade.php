@extends('layouts._pageLayout')

@section('content')
<div class="container py-5">
    <div class="row">
        {{-- LEFT SIDE: PROFILE INFO --}}
        <div class="col-lg-4 mb-4">
            <div class="premium-card text-center p-4 shadow-sm rounded-4 border-0 h-100">
                <div class="position-relative d-inline-block mb-4">
                    <img src="{{ asset('storage/' . ($adherent->photo ?? 'photos/default.png')) }}" 
                         class="rounded-circle border border-4 border-white shadow" 
                         style="width: 150px; height: 150px; object-fit: cover;"
                         alt="{{ $adherent->name }}">
                    <span class="position-absolute bottom-0 end-0 badge rounded-pill bg-success p-2 border border-3 border-white">
                        <i class="bi bi-patch-check-fill"></i>
                    </span>
                </div>
                
                <h3 class="fw-bold mb-1">{{ $adherent->name }}</h3>
                <p class="text-muted mb-3">{{ $adherent->role === 'admin' ? '🛡️ Administrateur' : '📖 Adhérent' }}</p>
                
                <div class="d-flex justify-content-center gap-2 mb-4">
                    <div class="px-3 py-2 bg-light rounded-3">
                        <div class="fw-bold text-primary fs-5">{{ $adherent->emprunts->count() }}</div>
                        <div class="small text-muted text-uppercase" style="font-size: 0.6rem;">Emprunts</div>
                    </div>
                    <div class="px-3 py-2 bg-light rounded-3">
                        <div class="fw-bold text-success fs-5">{{ $adherent->emprunts->where('statut', 'rendu')->count() }}</div>
                        <div class="small text-muted text-uppercase" style="font-size: 0.6rem;">Lus</div>
                    </div>
                </div>

                <hr class="my-4 opacity-50">

                <div class="text-start">
                    <div class="mb-3">
                        <label class="small text-muted fw-bold text-uppercase mb-1">Code Adhérent</label>
                        <div class="fw-bold"><i class="bi bi-hash me-2 text-primary"></i>{{ $adherent->codeA ?? 'N/A' }}</div>
                    </div>
                    <div class="mb-3">
                        <label class="small text-muted fw-bold text-uppercase mb-1">Email</label>
                        <div class="fw-bold"><i class="bi bi-envelope me-2 text-primary"></i>{{ $adherent->email }}</div>
                    </div>
                    <div class="mb-3">
                        <label class="small text-muted fw-bold text-uppercase mb-1">Adresse</label>
                        <div class="fw-bold"><i class="bi bi-geo-alt me-2 text-primary"></i>{{ $adherent->adresse ?? 'Non spécifiée' }}</div>
                    </div>
                    <div class="mb-0">
                        <label class="small text-muted fw-bold text-uppercase mb-1">Membre depuis</label>
                        <div class="fw-bold"><i class="bi bi-calendar-event me-2 text-primary"></i>{{ $adherent->created_at->format('d M Y') }}</div>
                    </div>
                </div>

                @can('update', $adherent)
                <div class="mt-4 pt-2">
                    <a href="{{ route('adherents.edit', $adherent->id) }}" class="btn btn-primary btn-custom w-100 rounded-pill shadow-sm">
                        <i class="bi bi-pencil-square me-2"></i>Modifier le Profil
                    </a>
                </div>
                @endcan

                @if(request('sup') != null)
                <div class="mt-3 p-3 bg-danger bg-opacity-10 border border-danger border-opacity-25 rounded-4">
                    <p class="small text-danger mb-3 fw-bold">⚠️ Action irréversible</p>
                    <form action="{{ route('adherents.destroy', $adherent->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm w-100 rounded-pill shadow-sm" onclick="return confirm('Supprimer ce compte ?')">
                            Confirmer la Suppression
                        </button>
                    </form>
                </div>
                @endif
            </div>
        </div>

        {{-- RIGHT SIDE: HISTORY & ACTIVITY --}}
        <div class="col-lg-8">
            <div class="premium-card p-4 shadow-sm rounded-4 border-0 mb-4 h-100">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h5 class="fw-bold mb-0">📜 Historique des Emprunts</h5>
                    <span class="badge bg-primary bg-opacity-10 text-primary px-3 py-2 rounded-pill">Total: {{ $adherent->emprunts->count() }}</span>
                </div>

                @if($adherent->emprunts->isEmpty())
                <div class="text-center py-5">
                    <img src="https://cdn-icons-png.flaticon.com/512/10433/10433048.png" width="80" class="mb-3 opacity-25" alt="Empty">
                    <h6 class="text-muted">Aucun emprunt enregistré pour le moment.</h6>
                    <a href="{{ route('livres.index') }}" class="btn btn-link text-decoration-none">Explorer le catalogue</a>
                </div>
                @else
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead>
                            <tr class="text-muted small fw-bold text-uppercase">
                                <th>Livre</th>
                                <th>Date Emprunt</th>
                                <th>Date Retour</th>
                                <th>Statut</th>
                                <th class="text-end">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($adherent->emprunts->sortByDesc('created_at') as $emp)
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center gap-3">
                                        <div class="bg-primary bg-opacity-10 text-primary rounded p-2">
                                            <i class="bi bi-book"></i>
                                        </div>
                                        <div>
                                            <div class="fw-bold">{{ $emp->livre->titre }}</div>
                                            <small class="text-muted">{{ $emp->livre->auteur }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td>{{ \Carbon\Carbon::parse($emp->dateEmp)->format('d/m/Y') }}</td>
                                <td>{{ \Carbon\Carbon::parse($emp->dateRetour)->format('d/m/Y') }}</td>
                                <td>
                                    @php
                                        $statusConfig = [
                                            'en_attente' => ['bg' => 'warning', 'label' => 'Attente', 'icon' => 'hourglass-split'],
                                            'valide' => ['bg' => 'success', 'label' => 'Validé', 'icon' => 'check-circle'],
                                            'rendu' => ['bg' => 'info', 'label' => 'Rendu', 'icon' => 'journal-check'],
                                            'refuse' => ['bg' => 'danger', 'label' => 'Refusé', 'icon' => 'x-circle'],
                                        ];
                                        $cfg = $statusConfig[$emp->statut] ?? ['bg' => 'secondary', 'label' => 'Inconnu', 'icon' => 'question-circle'];
                                    @endphp
                                    <span class="badge bg-{{ $cfg['bg'] }} bg-opacity-10 text-{{ $cfg['bg'] }} px-3 py-2 rounded-pill border border-{{ $cfg['bg'] }} border-opacity-25">
                                        <i class="bi bi-{{ $cfg['icon'] }} me-1"></i>{{ $cfg['label'] }}
                                    </span>
                                </td>
                                <td class="text-end">
                                    <a href="{{ route('emprunts.show', $emp->id) }}" class="btn btn-sm btn-light border rounded-circle" title="Voir détails">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>

<style>
    .fw-900 { font-weight: 900; }
    .btn-custom { transition: all 0.3s; }
    .btn-custom:hover { transform: translateY(-2px); }
</style>
@endsection