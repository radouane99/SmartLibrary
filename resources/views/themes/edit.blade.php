@extends('layouts._pageLayout')

@section('content')

<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">

            {{-- HEADER --}}
            <div class="mb-4 text-center">
                <h2 class="fw-bold text-dark mb-2">Modifier le Thème</h2>
                <p class="text-muted">Mettez à jour l'intitulé de cette catégorie.</p>
            </div>

            {{-- FORM CARD --}}
            <div class="premium-card">
                
                <div class="premium-card-header">
                    <h5 class="fw-bold mb-0 text-warning">
                        <i class="bi bi-pencil-square me-2"></i> Édition du thème #{{$theme->id}}
                    </h5>
                </div>

                <div class="premium-card-body">
                    <form action="{{ route('themes.update',['theme'=>$theme->id]) }}" method="POST">
                        @csrf
                        @method('PUT')

                        {{-- INTITULÉ --}}
                        <div class="mb-5">
                            <label class="form-label">Intitulé du Thème</label>
                            <div class="input-icon-wrapper">
                                <input type="text" 
                                       class="form-control @error('intitule') is-invalid @enderror" 
                                       placeholder="Ex: Science-Fiction, Histoire..." 
                                       name="intitule" 
                                       value="{{$theme->intitule}}">
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
                            <button type="submit" class="btn btn-warning btn-custom flex-grow-1 shadow text-dark">
                                <i class="bi bi-save me-1"></i> Mettre à jour
                            </button>
                        </div>

                    </form>
                </div>
            </div>

        </div>
    </div>
</div>

@endsection