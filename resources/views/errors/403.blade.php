@extends('layouts._pageLayout')

@section('content')
<div class="container py-5 text-center">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="premium-card p-5 border-0 shadow-lg rounded-4">
                <div class="mb-4">
                    <i class="bi bi-shield-lock-fill display-1 text-warning"></i>
                </div>
                <h1 class="display-4 fw-bold text-dark mb-3">403</h1>
                <h2 class="fw-bold mb-4">Accès Refusé</h2>
                <p class="text-muted fs-5 mb-5">
                    Vous n'avez pas les autorisations nécessaires pour accéder à cette section. Veuillez contacter l'administrateur si vous pensez qu'il s'agit d'une erreur.
                </p>
                <div class="d-flex justify-content-center gap-3">
                    <a href="{{ route('dashboard') }}" class="btn btn-primary btn-lg px-4 rounded-pill shadow-sm">
                        <i class="bi bi-speedometer2 me-2"></i> Dashboard
                    </a>
                    <a href="{{ route('home') }}" class="btn btn-light btn-lg px-4 rounded-pill border">
                        <i class="bi bi-house-door me-2"></i> Accueil
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
