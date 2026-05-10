@extends('layouts._pageLayout')

@section('content')

<section class="text-center text-lg-start py-5">
    <div class="container">
        <div class="row g-0 align-items-center justify-content-center">
            
            {{-- FORM COLUMN --}}
            <div class="col-lg-6 mb-5 mb-lg-0 z-1" style="margin-right: -30px; position: relative;">
                <div class="premium-card p-4 p-md-5">
                    
                    <div class="text-center mb-4">
                        <i class="bi bi-person-plus-fill fs-1 text-primary"></i>
                        <h2 class="fw-bold mt-2">Créer un compte</h2>
                        <p class="text-muted">Rejoignez SmartLibrary dès aujourd'hui.</p>
                    </div>

                    <form action="{{ route('toRegister') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        
                        <div class="row g-3 text-start">
                            {{-- CODE ADHERENT --}}
                            <div class="col-md-6">
                                <label class="form-label" for="codeA">Code Adhérent</label>
                                <div class="input-icon-wrapper">
                                    <input type="text" id="codeA" class="form-control @error('codeA') is-invalid @enderror" name="codeA" value="{{ old('codeA') }}"/>
                                    <i class="bi bi-upc-scan"></i>
                                </div>
                                @error('codeA') 
                                    <div class="text-danger mt-1 small fw-bold"><i class="bi bi-exclamation-circle me-1"></i> {{$message}}</div>
                                @enderror
                            </div>

                            {{-- NOM --}}
                            <div class="col-md-6">
                                <label class="form-label" for="nom">Nom Complet</label>
                                <div class="input-icon-wrapper">
                                    <input type="text" id="nom" class="form-control @error('nom') is-invalid @enderror" name="nom" value="{{ old('nom') }}"/>
                                    <i class="bi bi-person"></i>
                                </div>
                                @error('nom') 
                                    <div class="text-danger mt-1 small fw-bold"><i class="bi bi-exclamation-circle me-1"></i> {{$message}}</div>
                                @enderror
                            </div>

                            {{-- EMAIL --}}
                            <div class="col-md-6">
                                <label class="form-label" for="email">Adresse Email</label>
                                <div class="input-icon-wrapper">
                                    <input type="email" id="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}"/>
                                    <i class="bi bi-envelope"></i>
                                </div>
                                @error('email') 
                                    <div class="text-danger mt-1 small fw-bold"><i class="bi bi-exclamation-circle me-1"></i> {{$message}}</div>
                                @enderror
                            </div>

                            {{-- ADRESSE --}}
                            <div class="col-md-6">
                                <label class="form-label" for="adresse">Adresse</label>
                                <div class="input-icon-wrapper">
                                    <input type="text" id="adresse" class="form-control @error('adresse') is-invalid @enderror" name="adresse" value="{{ old('adresse') }}"/>
                                    <i class="bi bi-geo-alt"></i>
                                </div>
                                @error('adresse') 
                                    <div class="text-danger mt-1 small fw-bold"><i class="bi bi-exclamation-circle me-1"></i> {{$message}}</div>
                                @enderror
                            </div>

                            {{-- PASSWORD --}}
                            <div class="col-md-6">
                                <label class="form-label" for="password">Mot de passe</label>
                                <div class="input-icon-wrapper">
                                    <input type="password" id="password" class="form-control @error('password') is-invalid @enderror" name="password" />
                                    <i class="bi bi-lock"></i>
                                </div>
                                @error('password') 
                                    <div class="text-danger mt-1 small fw-bold"><i class="bi bi-exclamation-circle me-1"></i> {{$message}}</div>
                                @enderror
                            </div>

                            {{-- PASSWORD CONFIRM --}}
                            <div class="col-md-6">
                                <label class="form-label" for="password_confirmation">Confirmer Mot de passe</label>
                                <div class="input-icon-wrapper">
                                    <input type="password" id="password_confirmation" class="form-control" name="password_confirmation" />
                                    <i class="bi bi-shield-lock"></i>
                                </div>
                            </div>

                            {{-- PHOTO --}}
                            <div class="col-12 mt-3">
                                <label class="form-label">Photo de Profil (Optionnelle)</label>
                                <input type="file" class="form-control p-2 @error('photo') is-invalid @enderror" name="photo" />
                                @error('photo')
                                    <div class="text-danger mt-1 small fw-bold"><i class="bi bi-exclamation-circle me-1"></i> {{$message}}</div>
                                @enderror
                            </div>
                        </div>

                        {{-- SUBMIT --}}
                        <button type="submit" class="btn btn-primary btn-custom w-100 shadow mt-4">
                            <i class="bi bi-person-check-fill me-2"></i> S'inscrire
                        </button>
                    </form>

                    <div class="mt-4 text-center">
                        <p class="text-muted small mb-0">Vous avez déjà un compte ?</p>
                        <a href="{{ route('login') }}" class="text-decoration-none fw-bold text-primary">Se Connecter</a>
                    </div>
                </div>
            </div>

            {{-- IMAGE COLUMN --}}
            <div class="col-lg-5 d-none d-lg-block">
                <img src="https://images.unsplash.com/photo-1524995997946-a1c2e315a42f?ixlib=rb-4.0.3&auto=format&fit=crop&w=1200&q=80" 
                     class="w-100 rounded-4 shadow-lg" 
                     style="height: 700px; object-fit: cover;" 
                     alt="Library Background" />
            </div>

        </div>
    </div>
</section>

@endsection
