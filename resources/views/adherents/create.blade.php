@extends('layouts._pageLayout')

@section('content')

<div class="container py-4">

    <div class="row justify-content-center">
        <div class="col-md-10 col-lg-8">

            {{-- HEADER --}}
            <div class="mb-4 text-center">
                <h2 class="fw-bold text-dark mb-2">Ajouter un Adhérent</h2>
                <p class="text-muted">Créez un nouveau compte pour un membre de la bibliothèque.</p>
            </div>

            {{-- FORM CARD --}}
            <div class="premium-card">
                
                <div class="premium-card-header">
                    <h5 class="fw-bold mb-0 text-success">
                        <i class="bi bi-person-plus-fill me-2"></i> Informations de l'adhérent
                    </h5>
                </div>

                <div class="premium-card-body">
                    <form action="{{ route('adherents.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="row g-4 mb-4">
                            
                            {{-- CODE --}}
                            <div class="col-md-6">
                                <label class="form-label">Code Adhérent</label>
                                <div class="input-icon-wrapper">
                                    <input type="text" 
                                           class="form-control @error('codeA') is-invalid @enderror" 
                                           placeholder="Ex: ADH-2026" 
                                           name="codeA" 
                                           value="{{old('codeA')}}">
                                    <i class="bi bi-upc-scan"></i>
                                </div>
                                @error('codeA')
                                    <div class="text-danger mt-1 small fw-bold">
                                        <i class="bi bi-exclamation-circle me-1"></i> {{$message}}
                                    </div>
                                @enderror
                            </div>

                            {{-- NOM --}}
                            <div class="col-md-6">
                                <label class="form-label">Nom Complet</label>
                                <div class="input-icon-wrapper">
                                    <input type="text" 
                                           class="form-control @error('name') is-invalid @enderror" 
                                           placeholder="Nom et prénom" 
                                           name="name" 
                                           value="{{old('name')}}">
                                    <i class="bi bi-person"></i>
                                </div>
                                @error('name')
                                    <div class="text-danger mt-1 small fw-bold">
                                        <i class="bi bi-exclamation-circle me-1"></i> {{$message}}
                                    </div>
                                @enderror 
                            </div>

                            {{-- EMAIL --}}
                            <div class="col-md-6">
                                <label class="form-label">Email</label>
                                <div class="input-icon-wrapper">
                                    <input type="email" 
                                           class="form-control @error('email') is-invalid @enderror" 
                                           placeholder="adresse@email.com" 
                                           name="email" 
                                           value="{{old('email')}}">
                                    <i class="bi bi-envelope"></i>
                                </div>
                                @error('email')
                                    <div class="text-danger mt-1 small fw-bold">
                                        <i class="bi bi-exclamation-circle me-1"></i> {{$message}}
                                    </div>
                                @enderror
                            </div>

                            {{-- ADRESSE --}}
                            <div class="col-md-6">
                                <label class="form-label">Adresse Physique</label>
                                <div class="input-icon-wrapper">
                                    <input type="text" 
                                           class="form-control @error('adresse') is-invalid @enderror" 
                                           placeholder="Ville, Quartier..." 
                                           name="adresse" 
                                           value="{{old('adresse')}}">
                                    <i class="bi bi-geo-alt"></i>
                                </div>
                                @error('adresse')
                                    <div class="text-danger mt-1 small fw-bold">
                                        <i class="bi bi-exclamation-circle me-1"></i> {{$message}}
                                    </div>
                                @enderror
                            </div>

                            {{-- PASSWORD --}}
                            <div class="col-md-6">
                                <label class="form-label">Mot de Passe</label>
                                <div class="input-icon-wrapper">
                                    <input type="password" 
                                           class="form-control @error('password') is-invalid @enderror" 
                                           placeholder="Minimum 8 caractères" 
                                           name="password">
                                    <i class="bi bi-lock"></i>
                                </div>
                                @error('password')
                                    <div class="text-danger mt-1 small fw-bold">
                                        <i class="bi bi-exclamation-circle me-1"></i> {{$message}}
                                    </div>
                                @enderror
                            </div>

                            {{-- PASSWORD CONFIRMATION --}}
                            <div class="col-md-6">
                                <label class="form-label">Confirmer le Mot de Passe</label>
                                <div class="input-icon-wrapper">
                                    <input type="password" 
                                           class="form-control" 
                                           placeholder="Retapez le mot de passe" 
                                           name="password_confirmation">
                                    <i class="bi bi-shield-lock"></i>
                                </div>
                            </div>

                            {{-- PHOTO --}}
                            <div class="col-md-12">
                                <label class="form-label">Photo Personnelle (Optionnelle)</label>
                                <input type="file" 
                                       class="form-control p-3 @error('photo') is-invalid @enderror" 
                                       name="photo">
                                @error('photo')
                                    <div class="text-danger mt-1 small fw-bold">
                                        <i class="bi bi-exclamation-circle me-1"></i> {{$message}}
                                    </div>
                                @enderror
                            </div>

                        </div>

                        {{-- BUTTONS --}}
                        <div class="d-flex gap-3 mt-4">
                            <a class="btn btn-light btn-custom flex-grow-1 text-muted border" href="{{route('adherents.index')}}">
                                Annuler
                            </a>
                            <button type="submit" class="btn btn-success btn-custom flex-grow-1 shadow">
                                <i class="bi bi-check-circle me-1"></i> Enregistrer
                            </button>
                        </div>

                    </form>
                </div>
            </div>

        </div>
    </div>
</div>

@endsection