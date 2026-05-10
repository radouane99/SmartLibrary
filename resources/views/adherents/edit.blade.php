@extends('layouts._pageLayout')

@section('content')

<div class="container py-4">

    <div class="row justify-content-center">
        <div class="col-md-10 col-lg-8">

            {{-- HEADER --}}
            <div class="mb-4 text-center">
                <h2 class="fw-bold text-dark mb-2">Modifier l'Adhérent</h2>
                <p class="text-muted">Mettez à jour les informations du profil.</p>
            </div>

            {{-- FORM CARD --}}
            <div class="premium-card">
                
                <div class="premium-card-header">
                    <h5 class="fw-bold mb-0 text-warning">
                        <i class="bi bi-pencil-square me-2"></i> Édition du profil de {{$adherent->name}}
                    </h5>
                </div>

                <div class="premium-card-body">
                    {{-- ALERT STATUS --}}
                    @if(session('status'))
                        <div class="alert alert-success rounded-4 mb-4">
                            <i class="bi bi-check-circle-fill me-2"></i> {{ session('status') }}
                        </div>
                    @endif

                    <form action="{{ route('adherents.update', ['adherent'=>$adherent->id]) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="row g-4 mb-4">
                            {{-- PHOTO PREVIEW & INPUT --}}
                            <div class="col-12 text-center mb-4">
                                <div class="position-relative d-inline-block">
                                    <img src="{{ asset('storage/' . ($adherent->photo ?? 'photos/default.png')) }}" 
                                         class="rounded-circle shadow border border-5 border-white" 
                                         style="width: 150px; height: 150px; object-fit: cover;"
                                         id="profilePreview">
                                    <label for="photoInput" class="btn btn-primary btn-sm rounded-circle position-absolute bottom-0 end-0 p-2 shadow">
                                        <i class="bi bi-camera-fill"></i>
                                    </label>
                                    <input type="file" name="photo" id="photoInput" class="d-none" onchange="previewImage(this)">
                                </div>
                                <p class="text-muted small mt-2">Cliquez sur l'icône pour changer votre photo</p>
                                @error('photo')
                                    <div class="text-danger small fw-bold">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            {{-- CODE --}}
                            <div class="col-md-6">
                                <label class="form-label small fw-bold">Code Adhérent</label>
                                <div class="input-icon-wrapper">
                                    <input type="text" class="form-control bg-light" value="{{$adherent->codeA}}" disabled>
                                    <i class="bi bi-upc-scan"></i>
                                </div>
                            </div>

                            {{-- NOM --}}
                            <div class="col-md-6">
                                <label class="form-label small fw-bold">Nom Complet</label>
                                <div class="input-icon-wrapper">
                                    <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{$adherent->name}}">
                                    <i class="bi bi-person"></i>
                                </div>
                                @error('name') <div class="text-danger small">{{$message}}</div> @enderror 
                            </div>

                            {{-- EMAIL --}}
                            <div class="col-md-6">
                                <label class="form-label small fw-bold">Email</label>
                                <div class="input-icon-wrapper">
                                    <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{$adherent->email}}">
                                    <i class="bi bi-envelope"></i>
                                </div>
                                @error('email') <div class="text-danger small">{{$message}}</div> @enderror
                            </div>

                            {{-- ADRESSE --}}
                            <div class="col-md-6">
                                <label class="form-label small fw-bold">Adresse</label>
                                <div class="input-icon-wrapper">
                                    <input type="text" class="form-control @error('adresse') is-invalid @enderror" name="adresse" value="{{$adherent->adresse}}">
                                    <i class="bi bi-geo-alt"></i>
                                </div>
                                @error('adresse') <div class="text-danger small">{{$message}}</div> @enderror
                            </div>

                            <div class="col-12"><hr class="opacity-25"></div>

                            {{-- NEW PASSWORD --}}
                            <div class="col-md-6">
                                <label class="form-label small fw-bold">Nouveau Mot de Passe</label>
                                <div class="input-icon-wrapper">
                                    <input type="password" class="form-control @error('password') is-invalid @enderror" name="password" placeholder="••••••••">
                                    <i class="bi bi-lock"></i>
                                </div>
                                @error('password') <div class="text-danger small">{{$message}}</div> @enderror
                            </div>

                            {{-- PASSWORD CONFIRMATION --}}
                            <div class="col-md-6">
                                <label class="form-label small fw-bold">Confirmer le Mot de Passe</label>
                                <div class="input-icon-wrapper">
                                    <input type="password" class="form-control" name="password_confirmation" placeholder="••••••••">
                                    <i class="bi bi-shield-lock"></i>
                                </div>
                            </div>

                        </div>

                        {{-- BUTTONS --}}
                        <div class="d-flex gap-3">
                            <a class="btn btn-light btn-custom flex-grow-1 border" 
                               href="{{ auth()->user()->role === 'admin' ? route('adherents.index') : route('adherents.show', $adherent->id) }}">
                                <i class="bi bi-x-lg"></i> Annuler
                            </a>
                            <button type="submit" class="btn btn-warning btn-custom flex-grow-1 shadow text-dark fw-bold">
                                <i class="bi bi-check-lg"></i> Enregistrer les modifications
                            </button>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
</div>

<script>
    function previewImage(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('profilePreview').src = e.target.result;
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>

@endsection