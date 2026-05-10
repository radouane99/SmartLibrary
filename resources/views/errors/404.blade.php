@extends('layouts._pageLayout')

@section('content')
<div class="container py-5 text-center">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="premium-card p-5 border-0 shadow-lg rounded-4">
                <div class="mb-4">
                    <i class="bi bi-exclamation-octagon display-1 text-danger"></i>
                </div>
                <h1 class="display-4 fw-bold text-dark mb-3">404</h1>
                <h2 class="fw-bold mb-4">Oups ! Page introuvable</h2>
                <p class="text-muted fs-5 mb-5">
                    Désolé, la page que vous recherchez semble avoir disparu dans les rayons de notre bibliothèque imaginaire.
                </p>
                <div class="d-flex justify-content-center gap-3">
                    <a href="{{ route('home') }}" class="btn btn-primary btn-lg px-4 rounded-pill shadow-sm">
                        <i class="bi bi-house-door me-2"></i> Accueil
                    </a>
                    <a href="{{ url()->previous() }}" class="btn btn-light btn-lg px-4 rounded-pill border">
                        <i class="bi bi-arrow-left me-2"></i> Retour
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
