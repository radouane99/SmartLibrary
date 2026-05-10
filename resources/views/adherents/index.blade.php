@extends('layouts._pageLayout')

@section('content')

<div class="container py-4">

    {{-- HEADER --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="fw-bold text-dark">
                👥 Gestion des Adhérents
            </h1>
            <p class="text-muted">
                Consultez et gérez les membres de la bibliothèque.
            </p>
        </div>

        @can('create', App\Models\User::class)
            <a href="{{ route('adherents.create') }}" class="btn btn-success btn-custom shadow">
                <i class="bi bi-person-plus-fill me-1"></i> Nouvel Adhérent
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
                        <th class="ps-3"># Code</th>
                        <th>👤 Nom Complet</th>
                        <th>📧 Email</th>
                        <th>📍 Adresse</th>
                        <th>📅 Inscrit le</th>
                        <th class="text-center">⚙️ Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($db as $el)
                        <tr>
                            <td class="fw-bold ps-3 text-secondary">
                                <span class="badge bg-light text-dark border">{{$el->codeA ?? $el->id}}</span>
                            </td>
                            <td class="fw-bold text-dark">
                                <div class="d-flex align-items-center gap-2">
                                    <div class="bg-primary bg-opacity-10 text-primary rounded-circle d-flex justify-content-center align-items-center" style="width: 35px; height: 35px;">
                                        {{ substr($el->name, 0, 1) }}
                                    </div>
                                    {{$el->name}}
                                </div>
                            </td>
                            <td><a href="mailto:{{$el->email}}" class="text-decoration-none">{{$el->email}}</a></td>
                            <td><small class="text-muted">{{$el->adresse ?? '—'}}</small></td>
                            <td>{{$el->created_at ? $el->created_at->format('d/m/Y') : '—'}}</td>
                            <td class="text-center">
                                <div class="d-flex justify-content-center gap-2">
                                    @can('view', $el)
                                        <a href="{{ route('adherents.show',['adherent'=>$el->id]) }}" class="btn btn-sm btn-light border shadow-sm" title="Voir détails">
                                            <i class="bi bi-eye-fill"></i>
                                        </a>
                                    @endcan
                                    @can('update', $el)
                                        <a href="{{ route('adherents.edit',['adherent'=>$el->id]) }}" class="btn btn-sm btn-warning shadow-sm" title="Modifier">
                                            <i class="bi bi-pencil-fill"></i>
                                        </a>
                                    @endcan
                                    @can('delete', $el)
                                        <a href="{{ route('adherents.show',['adherent'=>$el->id, 'sup'=>1]) }}" class="btn btn-sm btn-danger shadow-sm" title="Supprimer">
                                            <i class="bi bi-trash3-fill"></i>
                                        </a>
                                    @endcan
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted py-5">
                                <i class="bi bi-people fs-1 d-block mb-2"></i>
                                Aucun adhérent trouvé.
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