@extends('layouts._pageLayout')

@section('content')

<section class="text-center text-lg-start py-5">
    <div class="container">
        <div class="row g-0 align-items-center justify-content-center">
            
            {{-- FORM COLUMN --}}
            <div class="col-lg-5 mb-5 mb-lg-0 z-1" style="margin-right: -30px; position: relative;">
                <div class="premium-card p-4 p-md-5">
                    
                    <div class="text-center mb-4">
                        <i class="bi bi-person-circle fs-1 text-primary"></i>
                        <h2 class="fw-bold mt-2">Bon retour !</h2>
                        <p class="text-muted">Connectez-vous pour accéder à votre espace.</p>
                    </div>

                    @if (session('status'))
                        <div class="alert alert-success rounded-4 mb-4" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <form action="{{route('toLogin')}}" method="post">
                        @csrf
                        
                        {{-- EMAIL --}}
                        <div class="mb-4 text-start">
                            <label class="form-label" for="email">Adresse Email</label>
                            <div class="input-icon-wrapper">
                                <input type="email" id="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{old('email')}}"/>
                                <i class="bi bi-envelope"></i>
                            </div>
                            @error('email') 
                                <div class="text-danger mt-1 small fw-bold">
                                    <i class="bi bi-exclamation-circle me-1"></i> {{$message}}
                                </div>
                            @enderror
                        </div>

                        {{-- PASSWORD --}}
                        <div class="mb-2 text-start">
                            <label class="form-label" for="password">Mot de passe</label>
                            <div class="input-icon-wrapper">
                                <input type="password" id="password" class="form-control @error('password') is-invalid @enderror" name="password" />
                                <i class="bi bi-lock"></i>
                            </div>
                            @error('password') 
                                <div class="text-danger mt-1 small fw-bold">
                                    <i class="bi bi-exclamation-circle me-1"></i> {{$message}}
                                </div>
                            @enderror
                        </div>

                        <div class="text-end mb-4">
                            <a href="{{ route('password.request') }}" class="text-decoration-none small fw-bold text-primary">Mot de passe oublié ?</a>
                        </div>

                        {{-- SUBMIT --}}
                        <button type="submit" class="btn btn-primary btn-custom w-100 shadow mt-3">
                            <i class="bi bi-box-arrow-in-right me-2"></i> Se Connecter
                        </button>
                    </form>
                </div>
            </div>

            {{-- IMAGE COLUMN --}}
            <div class="col-lg-6 d-none d-lg-block">
                <img src="https://images.unsplash.com/photo-1507842217343-583bb7270b66?ixlib=rb-4.0.3&auto=format&fit=crop&w=1200&q=80" 
                     class="w-100 rounded-4 shadow-lg" 
                     style="height: 600px; object-fit: cover;" 
                     alt="Library Background" />
            </div>

        </div>
    </div>
</section>

@endsection