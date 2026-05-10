@extends('layouts._pageLayout')

@section('content')

<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">

            {{-- HEADER --}}
            <div class="mb-4 text-center">
                <h2 class="fw-bold text-dark mb-2">Nouveau Thème</h2>
                <p class="text-muted">Créez une nouvelle catégorie pour organiser les livres.</p>
            </div>

            {{-- FORM CARD --}}
            <div class="premium-card">
                
                <div class="premium-card-header">
                    <h5 class="fw-bold mb-0 text-success">
                        <i class="bi bi-tag-fill me-2"></i> Détails du thème
                    </h5>
                </div>

                <div class="premium-card-body">
                    <form action="{{ route('themes.store') }}" method="POST">
                        @csrf

                        {{-- INTITULÉ --}}
                        <div class="mb-5">
                            <label class="form-label">Intitulé du Thème</label>
                            <div class="input-icon-wrapper">
                                <input type="text" 
                                       class="form-control @error('intitule') is-invalid @enderror" 
                                       placeholder="Ex: Science-Fiction, Histoire..." 
                                       name="intitule" 
                                       value="{{old('intitule')}}">
                                <i class="bi bi-fonts"></i>
                            </div>
                            @error('intitule')
                                <div class="text-danger mt-1 small fw-bold">
                                    <i class="bi bi-exclamation-circle me-1"></i> {{$message}}
                                </div>
                            @enderror 
                        </div>

                        {{-- BUTTONS --}}
                        <div class="d-flex gap-3">
                            <a class="btn btn-light btn-custom flex-grow-1 text-muted border" href="{{route('themes.index')}}">
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