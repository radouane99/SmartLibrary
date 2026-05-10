@extends('layouts._pageLayout')

@section('content')
<div class="container py-4">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="fw-bold text-danger"><i class="bi bi-exclamation-triangle-fill me-2"></i>Emprunts en Retard</h1>
            <p class="text-muted">Liste des livres non retournés après la date limite.</p>
        </div>
        <div class="d-flex gap-2">
            <span class="badge bg-danger fs-6 px-4 py-2 rounded-pill shadow">{{ $retards->count() }} retard(s)</span>
            <a href="{{ route('emprunts.index') }}" class="btn btn-outline-dark rounded-pill px-4">
                <i class="bi bi-arrow-left me-1"></i> Retour
            </a>
        </div>
    </div>

    @if($retards->isEmpty())
        <div class="text-center py-5">
            <div class="fs-1 mb-3">🎉</div>
            <h3 class="fw-bold text-success">Aucun retard !</h3>
            <p class="text-muted">Tous les livres ont été retournés à temps.</p>
        </div>
    @else
        <div class="premium-card shadow-sm rounded-4 overflow-hidden">
            <div class="table-responsive">
                <table class="table align-middle table-hover mb-0">
                    <thead>
                        <tr class="bg-danger bg-opacity-10">
                            <th class="px-4 py-3 text-danger small fw-bold text-uppercase">Adhérent</th>
                            <th class="py-3 text-danger small fw-bold text-uppercase">Livre</th>
                            <th class="py-3 text-danger small fw-bold text-uppercase">Date Emprunt</th>
                            <th class="py-3 text-danger small fw-bold text-uppercase">Date Retour Prévue</th>
                            <th class="py-3 text-danger small fw-bold text-uppercase">Jours de Retard</th>
                            <th class="px-4 py-3 text-danger small fw-bold text-uppercase text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($retards as $emp)
                        @php
                            $joursRetard = \Carbon\Carbon::parse($emp->dateRetour)->diffInDays(now());
                        @endphp
                        <tr class="{{ $joursRetard > 7 ? 'table-danger' : '' }}">
                            <td class="px-4">
                                <div class="fw-bold">{{ $emp->user->name ?? 'N/A' }}</div>
                                <small class="text-muted">{{ $emp->user->email ?? '' }}</small>
                            </td>
                            <td>
                                <div class="fw-bold text-primary">{{ $emp->livre->titre ?? 'N/A' }}</div>
                                <small class="text-muted">{{ $emp->livre->auteur ?? '' }}</small>
                            </td>
                            <td>{{ \Carbon\Carbon::parse($emp->dateEmp)->format('d/m/Y') }}</td>
                            <td class="text-danger fw-bold">{{ \Carbon\Carbon::parse($emp->dateRetour)->format('d/m/Y') }}</td>
                            <td>
                                <span class="badge {{ $joursRetard > 7 ? 'bg-danger' : 'bg-warning text-dark' }} rounded-pill px-3 py-2 fs-6">
                                    ⚠ {{ $joursRetard }} jour(s)
                                </span>
                            </td>
                            <td class="px-4 text-center">
                                <div class="d-flex justify-content-center gap-2">
                                    <form action="{{ route('emprunts.retourner', $emp->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-success rounded-pill px-3" onclick="return confirm('Marquer comme retourné ?')">
                                            <i class="bi bi-check-lg me-1"></i> Retourné
                                        </button>
                                    </form>
                                    <a href="{{ route('emprunts.show', $emp->id) }}" class="btn btn-sm btn-outline-dark rounded-pill px-3">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @endif
</div>
@endsection
