@extends('layouts._pageLayout')

@section('content')

<div class="container py-4">

    {{-- BREADCRUMB --}}
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('livres.index') }}" class="text-decoration-none">Catalogue</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{ $livre->titre }}</li>
        </ol>
    </nav>

    <div class="row g-4">
        {{-- COLONNE GAUCHE : VISUEL --}}
        <div class="col-lg-4">
            <div class="premium-card p-0 shadow-lg border-0 rounded-4 overflow-hidden sticky-top" style="top: 20px; z-index: 10;">
                <div class="bg-dark text-center py-5 position-relative overflow-hidden" style="min-height: 400px; display: flex; align-items: center; justify-content: center;">
                    {{-- Effet de fond flou --}}
                    @if($livre->couverture)
                        <div class="position-absolute top-0 start-0 w-100 h-100 opacity-25" 
                             style="background-image: url('{{ asset('storage/' . $livre->couverture) }}'); background-size: cover; filter: blur(20px);"></div>
                        <img src="{{ asset('storage/' . $livre->couverture) }}" 
                             class="rounded shadow-lg position-relative" 
                             style="width: 220px; height: 320px; object-fit: cover; z-index: 2;" alt="{{ $livre->titre }}">
                    @else
                        <div class="position-absolute top-0 start-0 w-100 h-100 opacity-25" 
                             style="background: linear-gradient(135deg, #1e3a8a, #7c3aed); filter: blur(20px);"></div>
                        <div class="rounded shadow-lg position-relative d-flex align-items-center justify-content-center" 
                             style="width: 220px; height: 320px; z-index: 2; background: linear-gradient(135deg, #1e3a8a, #3b82f6);">
                             <span style="font-size: 80px;">📖</span>
                        </div>
                    @endif
                </div>
                <div class="p-4 text-center">
                    <div class="mb-3">
                        <span class="badge bg-primary px-3 py-2 rounded-pill">{{ $livre->theme->intitule }}</span>
                    </div>
                    <div class="d-flex justify-content-center gap-2 mb-3">
                        @for($i=1; $i<=5; $i++)
                            <i class="bi bi-star-fill text-warning"></i>
                        @endfor
                    </div>
                    <p class="text-muted small">Ce livre a été emprunté <strong>{{ $livre->emprunts()->count() }}</strong> fois.</p>
                </div>
            </div>
        </div>

        {{-- COLONNE DROITE : INFOS ET ACTIONS --}}
        <div class="col-lg-8">
            <div class="premium-card p-5 border-0 shadow-sm rounded-4 h-100">
                
                <div class="mb-5">
                    <h1 class="display-5 fw-bold text-dark mb-2">{{ $livre->titre }}</h1>
                    <h4 class="text-primary fw-light mb-4">par <span class="fw-bold">{{ $livre->auteur }}</span></h4>
                    
                    <div class="d-flex gap-3 mb-4">
                        <div class="p-3 bg-light rounded-4 text-center flex-grow-1">
                            <div class="small text-muted text-uppercase fw-bold mb-1" style="font-size: 0.7rem;">Stock Actuel</div>
                            <div class="fs-4 fw-bold {{ $livre->nbExemplaire > 0 ? 'text-success' : 'text-danger' }}">
                                {{ $livre->nbExemplaire }} <span class="small fw-normal">unités</span>
                            </div>
                        </div>
                        <div class="p-3 bg-light rounded-4 text-center flex-grow-1">
                            <div class="small text-muted text-uppercase fw-bold mb-1" style="font-size: 0.7rem;">Catégorie</div>
                            <div class="fs-5 fw-bold text-dark">{{ $livre->theme->intitule }}</div>
                        </div>
                    </div>
                </div>

                <div class="mb-5">
                    <h5 class="fw-bold mb-3 border-bottom pb-2"><i class="bi bi-info-circle me-2"></i>Résumé de l'œuvre</h5>
                    <p class="text-muted fs-5 leading-relaxed">
                        L'ouvrage <strong>"{{ $livre->titre }}"</strong>, écrit par l'éminent auteur <strong>{{ $livre->auteur }}</strong>, est une pièce maîtresse de notre collection dans la catégorie <em>{{ $livre->theme->intitule }}</em>.
                        @if($livre->nbExemplaire > 0)
                            Bonne nouvelle ! Il reste actuellement <strong>{{ $livre->nbExemplaire }} exemplaires</strong> disponibles à la réservation immédiate.
                        @else
                            Malheureusement, ce livre est actuellement victime de son succès et n'est plus disponible en stock.
                        @endif
                    </p>
                </div>

                {{-- ACTIONS --}}
                <div class="d-flex flex-wrap gap-3 pt-4 border-top">
                    @if(auth()->user()->role === 'adherent')
                        @if($livre->nbExemplaire > 0)
                            <a href="{{ route('emprunts.create', ['livre_id' => $livre->id]) }}" class="btn btn-primary btn-lg px-5 rounded-pill shadow">
                                <i class="bi bi-bookmark-plus me-2"></i> Réserver maintenant
                            </a>
                        @else
                            <button class="btn btn-secondary btn-lg px-5 rounded-pill" disabled>
                                <i class="bi bi-x-circle me-2"></i> Indisponible
                            </button>
                        @endif
                    @endif

                    @can('update', $livre)
                        <a href="{{ route('livres.edit', $livre->id) }}" class="btn btn-warning btn-lg px-4 rounded-pill">
                            <i class="bi bi-pencil me-2"></i> Modifier
                        </a>
                        <button type="button" class="btn btn-outline-danger btn-lg px-4 rounded-pill" data-bs-toggle="modal" data-bs-target="#deleteModal">
                            <i class="bi bi-trash me-2"></i> Supprimer
                        </button>
                    @endcan

                    <a href="{{ route('livres.index') }}" class="btn btn-light btn-lg px-4 rounded-pill border">
                        <i class="bi bi-arrow-left me-2"></i> Retour
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- MODALE DE SUPPRESSION --}}
@can('delete', $livre)
<div class="modal fade" id="deleteModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow rounded-4">
            <div class="modal-body p-5 text-center">
                <i class="bi bi-exclamation-triangle display-1 text-danger mb-4"></i>
                <h3 class="fw-bold mb-3">Supprimer ce livre ?</h3>
                <p class="text-muted mb-4">Cette action est irréversible. Toutes les données associées à "{{ $livre->titre }}" seront effacées.</p>
                <div class="d-flex gap-3 justify-content-center">
                    <button type="button" class="btn btn-light px-4 rounded-pill border" data-bs-dismiss="modal">Annuler</button>
                    <form action="{{ route('livres.destroy', $livre->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger px-4 rounded-pill shadow">Oui, supprimer</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endcan

@endsection