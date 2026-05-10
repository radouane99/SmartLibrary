@extends('layouts._pageLayout')

@section('content')

<div class="container py-4">

    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">

            {{-- HEADER --}}
            <div class="mb-4 text-center">
                <h2 class="fw-bold text-dark mb-2">Modifier Emprunt</h2>
                <p class="text-muted">Mettez à jour les informations de cet emprunt.</p>
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
                        <i class="bi bi-pencil-square me-2"></i> Édition de l'emprunt #{{ $emprunt->id }}
                    </h5>
                </div>

                <div class="premium-card-body">
                    <form action="{{ route('emprunts.update', ['emprunt'=>$emprunt->id]) }}" method="POST">
                        @csrf
                        @method('PUT')

                        {{-- LIVRE --}}
                        <div class="mb-4">
                            <label class="form-label">Livre emprunté</label>
                            <div class="input-icon-wrapper">
                                <select name="livre_id" class="form-select @error('livre_id') is-invalid @enderror">
                                    @foreach ($livres as $el)
                                        <option {{$emprunt->livre_id == $el->id ? 'selected' : ''}} value="{{$el->id}}">
                                            {{$el->titre}}
                                        </option>                    
                                    @endforeach
                                </select>
                                <i class="bi bi-book"></i>
                            </div>
                            @error('livre_id')
                                <div class="text-danger mt-1 small fw-bold">
                                    <i class="bi bi-exclamation-circle me-1"></i> {{$message}}
                                </div>
                            @enderror 
                        </div>

                        {{-- ADHÉRENT --}}
                        <div class="mb-4">
                            <label class="form-label">Adhérent</label>
                            <div class="input-icon-wrapper">
                                <select name="adherent_id" class="form-select @error('adherent_id') is-invalid @enderror">
                                    @foreach ($adherents as $el)
                                        <option {{$emprunt->user_id == $el->id ? 'selected' : ''}} value="{{$el->id}}">
                                            {{$el->name}}
                                        </option>                    
                                    @endforeach
                                </select>
                                <i class="bi bi-person"></i>
                            </div>
                            @error('adherent_id')
                                <div class="text-danger mt-1 small fw-bold">
                                    <i class="bi bi-exclamation-circle me-1"></i> {{$message}}
                                </div>
                            @enderror 
                        </div>

                        {{-- DATE EMPRUNT --}}
                        <div class="mb-4">
                            <label class="form-label">Date d'Emprunt</label>
                            <div class="input-icon-wrapper">
                                <input type="date" 
                                       class="form-control @error('dateEmp') is-invalid @enderror" 
                                       name="dateEmp" 
                                       value="{{$emprunt->dateEmp}}">
                                <i class="bi bi-calendar-check"></i>
                            </div>
                            @error('dateEmp')
                                <div class="text-danger mt-1 small fw-bold">
                                    <i class="bi bi-exclamation-circle me-1"></i> {{$message}}
                                </div>
                            @enderror
                        </div>

                        {{-- DATE RETOUR --}}
                        <div class="mb-5">
                            <label class="form-label">Date de Retour Prévue</label>
                            <div class="input-icon-wrapper">
                                <input type="date" 
                                       class="form-control @error('dateRetour') is-invalid @enderror" 
                                       name="dateRetour" 
                                       value="{{$emprunt->dateRetour}}">
                                <i class="bi bi-calendar-event"></i>
                            </div>
                            @error('dateRetour')
                                <div class="text-danger mt-1 small fw-bold">
                                    <i class="bi bi-exclamation-circle me-1"></i> {{$message}}
                                </div>
                            @enderror
                        </div>

                        {{-- BUTTONS --}}
                        <div class="d-flex gap-3">
                            <a class="btn btn-light btn-custom flex-grow-1 text-muted border" href="{{route('emprunts.index')}}">
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