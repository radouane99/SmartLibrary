@extends('layouts._pageLayout')

@section('content')

<div class="container py-4">

    {{-- HEADER --}}
    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>
            <h1 class="fw-bold text-dark">
                📚 Catalogue des Livres
            </h1>

            <p class="text-muted">
                Découvrez et réservez les meilleurs ouvrages de notre bibliothèque.
            </p>
        </div>

        @can('create', App\Models\Livre::class)
            <a href="{{ route('livres.create') }}" class="btn btn-primary btn-custom shadow">
                <i class="bi bi-plus-circle me-1"></i> Nouveau Livre
            </a>
        @endcan

    </div>

    {{-- STATUS --}}
    @session('status')
        <div class="alert alert-success shadow-sm rounded-4">
            <i class="bi bi-check-circle-fill me-2"></i> {{ session('status') }}
        </div>
    @endsession

    {{-- FILTER + SEARCH --}}
    <div class="card border-0 shadow-sm rounded-4 mb-4 bg-white">
        <div class="card-body p-4">
            <div class="row g-3 align-items-end">
                {{-- FILTER CATEGORY --}}
                <div class="col-md-3">
                    <label class="form-label text-muted small fw-bold text-uppercase">Catégorie</label>
                    <select id="themeFilter" class="form-select border-0 bg-light" onchange="applyFilters()">
                        <option value="-1">Toutes les catégories</option>
                        @foreach ($theme as $el)
                            <option value="{{$el->id}}" {{ $themeSel == $el->id ? 'selected' : '' }}>{{$el->intitule}}</option>
                        @endforeach
                    </select>
                </div>

                {{-- FILTER STOCK --}}
                <div class="col-md-3">
                    <label class="form-label text-muted small fw-bold text-uppercase">Disponibilité</label>
                    <select id="stockFilter" class="form-select border-0 bg-light" onchange="applyFilters()">
                        <option value="all">Tous les livres</option>
                        <option value="available">En stock uniquement</option>
                    </select>
                </div>

                {{-- SEARCH --}}
                <div class="col-md-6">
                    <label class="form-label text-muted small fw-bold text-uppercase">Recherche</label>
                    <div class="input-group">
                        <span class="input-group-text bg-light border-0 text-muted px-3"><i class="bi bi-search"></i></span>
                        <input type="text" id="searchInput" class="form-control border-0 bg-light py-2" 
                               placeholder="Titre, auteur..." onkeyup="applyFilters()" value="{{$val}}">
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- GRILLE DE LIVRES (Conteneur pour recherche instantanée) --}}
    <div id="booksGrid">
        @include('livres._booksGrid', ['db' => $db])
    </div>

</div>

<script>
    function applyFilters() {
        const theme = document.getElementById('themeFilter').value;
        const stock = document.getElementById('stockFilter').value;
        const search = document.getElementById('searchInput').value;
        
        const grid = document.getElementById('booksGrid');
        grid.style.opacity = '0.5';

        // Simulation de recherche instantanée via l'URL (ou AJAX si on veut être parfait)
        // Pour l'instant, on recharge proprement avec les paramètres
        clearTimeout(window.searchTimer);
        window.searchTimer = setTimeout(() => {
            const url = new URL(window.location.href);
            url.searchParams.set('themeSel', theme);
            url.searchParams.set('val', search);
            url.searchParams.set('stock', stock);
            
            // On peut utiliser fetch() pour ne mettre à jour que le grid sans recharger la page
            fetch(url.toString(), {
                headers: { 'X-Requested-With': 'XMLHttpRequest' }
            })
            .then(res => res.text())
            .then(html => {
                grid.innerHTML = html;
                grid.style.opacity = '1';
                // Update URL sans recharger
                window.history.pushState({}, '', url);
            });
        }, 300);
    }
</script>

@endsection