@extends('layouts._pageLayout')

@section('content')

<div class="container py-4">

    {{-- HEADER --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="fw-bold text-dark">
                🏷️ Gestion des Thèmes
            </h1>
            <p class="text-muted">
                Consultez et gérez les catégories de livres.
            </p>
        </div>

        @can('create', App\Models\Theme::class)
            <a href="{{ route('themes.create') }}" class="btn btn-success btn-custom shadow">
                <i class="bi bi-plus-circle-fill me-1"></i> Nouveau Thème
            </a>
        @endcan
    </div>

    {{-- STATUS --}}
    @session('status')
        <div class="alert alert-success rounded-4 shadow-sm mb-4">
            <i class="bi bi-check-circle-fill me-2"></i> {{ session('status') }}
        </div>
    @endsession

    {{-- TABLE --}}
    <div class="premium-card">
        <div class="table-responsive p-3">
            <table class="table align-middle table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="ps-3" style="width: 10%;">#</th>
                        <th style="width: 70%;">Intitulé du Thème</th>
                        <th class="text-center" style="width: 20%;">⚙️ Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($db as $el)
                        <tr>
                            <td class="fw-bold ps-3">{{$el->id}}</td>
                            <td>
                                <span class="badge bg-primary bg-opacity-10 text-primary border border-primary-subtle rounded-pill px-3 py-2 fs-6">
                                    {{$el->intitule}}
                                </span>
                            </td>
                            <td class="text-center">
                                <div class="d-flex justify-content-center gap-2">
                                    @can('view', $el)
                                        <a href="{{ route('themes.show',['theme'=>$el->id]) }}" class="btn btn-sm btn-light border shadow-sm" title="Voir détails">
                                            <i class="bi bi-eye-fill"></i>
                                        </a>
                                    @endcan
                                    @can('update', $el)
                                        <a href="{{ route('themes.edit',$el->id) }}" class="btn btn-sm btn-warning shadow-sm" title="Modifier">
                                            <i class="bi bi-pencil-fill"></i>
                                        </a>
                                    @endcan
                                    @can('delete', $el)
                                        <a href="{{ route('themes.show',['theme'=>$el->id, 'sup'=>1]) }}" class="btn btn-sm btn-danger shadow-sm" title="Supprimer">
                                            <i class="bi bi-trash3-fill"></i>
                                        </a>
                                    @endcan
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="text-center text-muted py-5">
                                <i class="bi bi-tags fs-1 d-block mb-2"></i>
                                Aucun thème trouvé.
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