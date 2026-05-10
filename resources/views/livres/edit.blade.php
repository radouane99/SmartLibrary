@extends('layouts._pageLayout')

@section('content')

<div class="container py-4">

    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-7">

            {{-- HEADER --}}
            <div class="mb-4 text-center">
                <h2 class="fw-bold text-dark mb-2">Modifier le Livre</h2>
                <p class="text-muted">Mettez à jour les informations du livre facilement.</p>
            </div>

            {{-- STATUS --}}
            @session('status')
                <div class="alert alert-danger rounded-4 shadow-sm mb-4">
                    <i class="bi bi-exclamation-circle-fill me-2"></i>
                    {{ session('status') }}
                </div>
            @endsession

            {{-- FORM CARD --}}
            <div class="premium-card">
                
                <div class="premium-card-header">
                    <h5 class="fw-bold mb-0 text-warning">
                        <i class="bi bi-pencil-square me-2"></i> Édition: {{$livre->titre}}
                    </h5>
                </div>

                <div class="premium-card-body">
                    <form action="{{ route('livres.update',['livre'=>$livre->id]) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="row g-4 mb-4">
                            {{-- TITRE --}}
                            <div class="col-md-12">
                                <label class="form-label">Titre du Livre</label>
                                <div class="input-icon-wrapper">
                                    <input type="text"
                                           class="form-control @error('titre') is-invalid @enderror"
                                           placeholder="Titre du livre"
                                           name="titre"
                                           value="{{$livre->titre}}">
                                    <i class="bi bi-book"></i>
                                </div>
                                @error('titre')
                                    <div class="text-danger mt-1 small fw-bold">
                                        <i class="bi bi-exclamation-circle me-1"></i> {{$message}}
                                    </div>
                                @enderror
                            </div>

                            {{-- AUTEUR --}}
                            <div class="col-md-6">
                                <label class="form-label">Auteur</label>
                                <div class="input-icon-wrapper">
                                    <input type="text"
                                           class="form-control @error('auteur') is-invalid @enderror"
                                           placeholder="Nom de l'auteur"
                                           name="auteur"
                                           value="{{$livre->auteur}}">
                                    <i class="bi bi-pen"></i>
                                </div>
                                @error('auteur')
                                    <div class="text-danger mt-1 small fw-bold">
                                        <i class="bi bi-exclamation-circle me-1"></i> {{$message}}
                                    </div>
                                @enderror
                            </div>

                            {{-- EXEMPLAIRES --}}
                            <div class="col-md-6">
                                <label class="form-label">Nombre des Exemplaires</label>
                                <div class="input-icon-wrapper">
                                    <input type="number"
                                           class="form-control @error('nbExemplaire') is-invalid @enderror"
                                           placeholder="Nombre d'exemplaires"
                                           name="nbExemplaire"
                                           value="{{$livre->nbExemplaire}}">
                                    <i class="bi bi-boxes"></i>
                                </div>
                                @error('nbExemplaire')
                                    <div class="text-danger mt-1 small fw-bold">
                                        <i class="bi bi-exclamation-circle me-1"></i> {{$message}}
                                    </div>
                                @enderror
                            </div>

                            {{-- THEME --}}
                            <div class="col-md-12">
                                <label class="form-label">Thème / Catégorie</label>
                                <div class="input-icon-wrapper">
                                    <select name="theme_id" class="form-select @error('theme_id') is-invalid @enderror">
                                        @foreach ($theme as $el)
                                            <option {{$livre->theme_id == $el->id ? 'selected' : ''}} value="{{$el->id}}">
                                                {{$el->intitule}}
                                            </option>
                                        @endforeach
                                    </select>
                                    <i class="bi bi-tags"></i>
                                </div>
                                @error('theme_id')
                                    <div class="text-danger mt-1 small fw-bold">
                                        <i class="bi bi-exclamation-circle me-1"></i> {{$message}}
                                    </div>
                                @enderror
                            </div>

                            {{-- COUVERTURE --}}
                            <div class="col-md-12">
                                <label class="form-label">Photo de couverture</label>
                                @if($livre->couverture)
                                    <div class="mb-2">
                                        <img src="{{ asset('storage/' . $livre->couverture) }}" class="rounded-3 shadow-sm" style="max-height: 120px;" alt="Couverture actuelle">
                                        <small class="d-block text-muted mt-1">Couverture actuelle</small>
                                    </div>
                                @endif
                                <input type="file" 
                                       class="form-control @error('couverture') is-invalid @enderror" 
                                       name="couverture" 
                                       accept="image/*">
                                <small class="text-muted">Laissez vide pour garder l'image actuelle.</small>
                                @error('couverture')
                                    <div class="text-danger mt-1 small fw-bold">
                                        <i class="bi bi-exclamation-circle me-1"></i> {{$message}}
                                    </div>
                                @enderror
                            </div>
                        </div>

                        {{-- BUTTONS --}}
                        <div class="d-flex gap-3">
                            <a class="btn btn-light btn-custom flex-grow-1 text-muted border" href="{{route('livres.index')}}">
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