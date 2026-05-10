@extends('layouts._pageLayout')

@section('content')
<section class="py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-5">
                <div class="premium-card p-4 p-md-5 shadow-lg">
                    <div class="text-center mb-4">
                        <i class="bi bi-key-fill fs-1 text-primary"></i>
                        <h2 class="fw-bold mt-2">Réinitialisation</h2>
                        <p class="text-muted small">Choisissez un nouveau mot de passe sécurisé.</p>
                    </div>

                    <form action="{{ route('password.update') }}" method="POST">
                        @csrf
                        <input type="hidden" name="token" value="{{ $token }}">

                        <div class="mb-3">
                            <label for="email" class="form-label">Adresse Email</label>
                            <div class="input-icon-wrapper">
                                <input type="email" id="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ $email ?? old('email') }}" required readonly>
                                <i class="bi bi-envelope"></i>
                            </div>
                            @error('email')
                                <div class="text-danger mt-1 small fw-bold">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label">Nouveau mot de passe</label>
                            <div class="input-icon-wrapper">
                                <input type="password" id="password" class="form-control @error('password') is-invalid @enderror" name="password" required>
                                <i class="bi bi-lock"></i>
                            </div>
                            @error('password')
                                <div class="text-danger mt-1 small fw-bold">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="password_confirmation" class="form-label">Confirmer le mot de passe</label>
                            <div class="input-icon-wrapper">
                                <input type="password" id="password_confirmation" class="form-control" name="password_confirmation" required>
                                <i class="bi bi-shield-lock"></i>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary btn-custom w-100 shadow">
                            Mettre à jour le mot de passe
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
