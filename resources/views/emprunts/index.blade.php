@extends('layouts._pageLayout')

@section('content')

<div class="container py-4">

    {{-- HEADER --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="fw-bold text-dark">
                📋 Suivi des Emprunts
            </h1>
            <p class="text-muted">
                Consultez et gérez les prêts de livres.
            </p>
        </div>

        @can('create', App\Models\Emprunt::class)
            <a href="{{ route('emprunts.create') }}" class="btn btn-success btn-custom shadow">
                <i class="bi bi-plus-circle-fill me-1"></i> Nouvel Emprunt
            </a>
        @endcan
    </div>

    {{-- STATUS --}}
    @session('status')
        <div class="alert alert-success rounded-4 shadow-sm mb-4">
            <i class="bi bi-check-circle-fill me-2"></i> {{ session('status') }}
        </div>
    @endsession

    {{-- FILTER FORM --}}
    <div class="premium-card mb-4">
        <div class="premium-card-body py-3">
            <form action="{{ route('emprunts.index') }}" method="get" class="row align-items-end g-3">
                
                <div class="col-md-4">
                    <label class="form-label mb-1"><i class="bi bi-calendar3 me-1"></i> Date Emprunt (Début)</label>
                    <input type="date" class="form-control" name="dateEmpD" value="{{$dateEmpD}}">
                </div>
                
                <div class="col-md-4">
                    <label class="form-label mb-1"><i class="bi bi-calendar3 me-1"></i> Date Emprunt (Fin)</label>
                    <input type="date" class="form-control" name="dateEmpF" value="{{$dateEmpF}}">
                </div>
                
                <div class="col-md-4">
                    <button type="submit" class="btn btn-dark btn-custom w-100 shadow-sm">
                        <i class="bi bi-search me-1"></i> Filtrer
                    </button>
                </div>

            </form>
        </div>
    </div>

    {{-- TABLE --}}
    <div class="premium-card">
        <div class="table-responsive p-3">
            <table class="table align-middle table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="ps-3">#</th>
                        <th>📖 Livre</th>
                        <th>✍️ Auteur</th>
                        <th>👤 Adhérent</th>
                        <th>📅 Emprunt</th>
                        <th>📅 Retour Prévu</th>
                        <th>État</th>
                        <th class="text-center">⚙️ Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($db as $el)
                        <tr>
                            <td class="fw-bold ps-3">{{$el->id}}</td>
                            <td class="fw-bold text-primary">{{$el->livre->titre ?? 'Livre Supprimé'}}</td>
                            <td><small class="text-muted">{{$el->livre->auteur ?? '—'}}</small></td>
                            <td>{{$el->user->name ?? 'Adhérent Supprimé'}}</td>
                            <td>{{$el->dateEmp}}</td>
                            <td>{{$el->dateRetour}}</td>
                            <td>
                                @if($el->statut === 'en_attente')
                                    <span class="badge bg-warning text-dark rounded-pill px-3">⌛ En attente</span>
                                @elseif($el->statut === 'valide')
                                    @if($el->dateRetour < now()->toDateString())
                                        <span class="badge bg-danger rounded-pill px-3">⚠ Retard</span>
                                    @else
                                        <span class="badge bg-success rounded-pill px-3">✅ Actif</span>
                                    @endif
                                @elseif($el->statut === 'refuse')
                                    <span class="badge bg-danger-subtle text-danger rounded-pill px-3 border border-danger">❌ Refusé</span>
                                @else
                                    <span class="badge bg-secondary rounded-pill px-3">📚 Rendu</span>
                                @endif
                            </td>
                            <td class="text-center">
                                <div class="d-flex justify-content-center gap-1 flex-wrap">
                                    {{-- BOUTON VALIDER (Admin + en_attente) --}}
                                    @if(auth()->user()->role === 'admin' && $el->statut === 'en_attente')
                                        <form action="{{ route('emprunts.valider', $el->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-success shadow-sm" title="Valider">
                                                <i class="bi bi-check-lg"></i> Valider
                                            </button>
                                        </form>
                                        <form action="{{ route('emprunts.refuser', $el->id) }}" method="POST" class="d-inline"
                                              onsubmit="return confirm('Refuser cette demande ? Le stock sera restauré.')">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-outline-danger shadow-sm" title="Refuser">
                                                <i class="bi bi-x-lg"></i> Refuser
                                            </button>
                                        </form>
                                    @endif

                                    {{-- BOUTON RETOURNER (Admin + valide) --}}
                                    @if(auth()->user()->role === 'admin' && $el->statut === 'valide')
                                        <form action="{{ route('emprunts.retourner', $el->id) }}" method="POST" class="d-inline"
                                              onsubmit="return confirm('Marquer ce livre comme retourné ?')">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-primary shadow-sm" title="Retour du livre">
                                                <i class="bi bi-arrow-return-left"></i> Retourné
                                            </button>
                                        </form>
                                        <form action="{{ route('emprunts.rappeler', $el->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-info text-white shadow-sm" title="Envoyer un rappel manuel">
                                                <i class="bi bi-bell-fill"></i> Rappel
                                            </button>
                                        </form>
                                    @endif

                                    {{-- BOUTON PDF (Si valide ou rendu) --}}
                                    @if(in_array($el->statut, ['valide', 'rendu']))
                                        <a href="{{ route('emprunts.pdf', $el->id) }}" class="btn btn-sm btn-outline-danger shadow-sm" title="Télécharger PDF" target="_blank">
                                            <i class="bi bi-file-earmark-pdf"></i> PDF
                                        </a>
                                    @endif

                                    @can('view', $el)
                                        <a href="{{ route('emprunts.show',['emprunt'=>$el->id]) }}" class="btn btn-sm btn-light border shadow-sm" title="Voir détails">
                                            <i class="bi bi-eye-fill"></i>
                                        </a>
                                    @endcan
                                    @can('update', $el)
                                        <a href="{{ route('emprunts.edit',['emprunt'=>$el->id]) }}" class="btn btn-sm btn-warning shadow-sm" title="Modifier">
                                            <i class="bi bi-pencil-fill"></i>
                                        </a>
                                    @endcan
                                    @can('delete', $el)
                                        <form action="{{ route('emprunts.destroy', $el->id) }}" method="POST" class="d-inline"
                                              onsubmit="return confirm('Supprimer définitivement cet emprunt ?')">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger shadow-sm" title="Supprimer">
                                                <i class="bi bi-trash3-fill"></i>
                                            </button>
                                        </form>
                                    @endcan
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center text-muted py-5">
                                <i class="bi bi-journal-x fs-1 d-block mb-2"></i>
                                Aucun emprunt trouvé.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- PAGINATION --}}
    <div class="d-flex justify-content-center mt-4">
        {{ $db->links() }}
    </div>

</div>

@endsection