@extends('layouts._pageLayout')

@section('content')
<section class="py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-5">
                <div class="premium-card p-4 p-md-5 shadow-lg">
                    <div class="text-center mb-4">
                        <i class="bi bi-shield-lock fs-1 text-primary"></i>
                        <h2 class="fw-bold mt-2">Mot de passe oublié</h2>
                        <p class="text-muted small">Entrez votre email pour recevoir un lien de réinitialisation.</p>
                    </div>

                    @if (session('status'))
                        <div class="alert alert-success rounded-4 mb-4" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <form action="{{ route('password.email') }}" method="POST">
                        @csrf
                        <div class="mb-4">
                            <label for="email" class="form-label">Adresse Email</label>
                            <div class="input-icon-wrapper">
                                <input type="email" id="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autofocus>
                                <i class="bi bi-envelope"></i>
                            </div>
                            @error('email')
                                <div class="text-danger mt-1 small fw-bold">{{ $message }}</div>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-primary btn-custom w-100 shadow">
                            Envoyer le lien
                        </button>
                    </form>

                    <div class="mt-4 text-center">
                        <a href="{{ route('login') }}" class="text-decoration-none small text-primary fw-bold">
                            <i class="bi bi-arrow-left"></i> Retour à la connexion
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
