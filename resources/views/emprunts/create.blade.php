@extends('layouts._pageLayout')

@section('content')

<div class="container py-4">

    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">

            {{-- HEADER --}}
            <div class="mb-4 text-center">
                @if(auth()->user()->role === 'adherent')
                    <h2 class="fw-bold text-dark mb-2">Demande de Réservation</h2>
                    <p class="text-muted">Réservez votre livre et passez le récupérer à la bibliothèque.</p>
                @else
                    <h2 class="fw-bold text-dark mb-2">Nouvel Emprunt</h2>
                    <p class="text-muted">Enregistrez un nouveau prêt pour un adhérent.</p>
                @endif
            </div>

            {{-- STATUS --}}
            @if(session('status'))
                <div class="alert alert-danger rounded-4 shadow-sm mb-4">
                    <i class="bi bi-exclamation-circle-fill me-2"></i>
                    {{ session('status') }}
                </div>
            @endif

            {{-- FORM CARD --}}
            <div class="premium-card shadow-lg">
                
                <div class="premium-card-header bg-primary bg-opacity-10">
                    <h5 class="fw-bold mb-0 text-primary">
                        <i class="bi {{ auth()->user()->role === 'adherent' ? 'bi-bookmark-star-fill' : 'bi-arrow-left-right' }} me-2"></i> 
                        {{ auth()->user()->role === 'adherent' ? 'Confirmer ma réservation' : 'Informations de l\'emprunt' }}
                    </h5>
                </div>

                <div class="premium-card-body">
                    <form action="{{ route('emprunts.store') }}" method="POST">
                        @csrf

                        {{-- LIVRE --}}
                        <div class="mb-4">
                            <label class="form-label small fw-bold">Livre sélectionné</label>
                            <div class="input-icon-wrapper">
                                @if(request('livre_id') && $livres->find(request('livre_id')))
                                    @php $selectedLivre = $livres->find(request('livre_id')); @endphp
                                    <div class="form-control bg-light d-flex align-items-center border-0 py-3">
                                        <i class="bi bi-book text-primary me-2"></i>
                                        <strong>{{ $selectedLivre->titre }}</strong>
                                        <input type="hidden" name="livre_id" value="{{ $selectedLivre->id }}">
                                    </div>
                                @else
                                    <select name="livre_id" class="form-select @error('livre_id') is-invalid @enderror">
                                        <option value="" selected disabled>Choisir un livre...</option>
                                        @foreach ($livres as $el)
                                            <option value="{{$el->id}}" {{ old('livre_id') == $el->id ? 'selected' : '' }}>{{$el->titre}}</option>                    
                                        @endforeach
                                    </select>
                                    <i class="bi bi-book"></i>
                                @endif
                            </div>
                            @error('livre_id')
                                <div class="text-danger mt-1 small fw-bold">
                                    <i class="bi bi-exclamation-circle me-1"></i> {{$message}}
                                </div>
                            @enderror 
                        </div>

                        {{-- ADHÉRENT (Hidden if simple user) --}}
                        @if(auth()->user()->role === 'adherent')
                            <input type="hidden" name="adherent_id" value="{{ auth()->user()->id }}">
                            <div class="mb-4">
                                <label class="form-label small fw-bold">Emprunteur</label>
                                <div class="form-control bg-light d-flex align-items-center border-0 py-3">
                                    <i class="bi bi-person-circle text-primary me-2"></i>
                                    <strong>{{ auth()->user()->name }}</strong>
                                </div>
                            </div>
                        @else
                            <div class="mb-4">
                                <label class="form-label small fw-bold">Sélectionner l'adhérent</label>
                                <div class="input-icon-wrapper">
                                    <select name="adherent_id" class="form-select @error('adherent_id') is-invalid @enderror">
                                        <option value="" selected disabled>Choisir un adhérent...</option>
                                        @foreach ($adherents as $el)
                                            <option value="{{$el->id}}" {{ old('adherent_id') == $el->id ? 'selected' : '' }}>{{$el->name}}</option>                    
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
                        @endif

                        {{-- DATE EMPRUNT (HIDDEN) --}}
                        <input type="date" name="dateEmp" hidden value="{{date('Y-m-d')}}">

                        {{-- DATE RETOUR (Auto-fill for 15 days for adherent) --}}
                        <div class="mb-5">
                            <label class="form-label small fw-bold">Date de Retour Souhaitée</label>
                            <div class="input-icon-wrapper">
                                <input type="date" 
                                       class="form-control @error('dateRetour') is-invalid @enderror" 
                                       name="dateRetour" 
                                       value="{{ old('dateRetour', date('Y-m-d', strtotime('+15 days'))) }}">
                                <i class="bi bi-calendar-event"></i>
                            </div>
                            @error('dateRetour')
                                <div class="text-danger mt-1 small fw-bold">
                                    <i class="bi bi-exclamation-circle me-1"></i> {{$message}}
                                </div>
                            @enderror
                            @if(auth()->user()->role === 'adherent')
                                <small class="text-muted mt-2 d-block">
                                    <i class="bi bi-info-circle me-1"></i> La durée maximale conseillée est de 15 jours.
                                </small>
                            @endif
                        </div>

                        {{-- BUTTONS --}}
                        <div class="d-flex gap-3">
                            <a class="btn btn-light btn-custom flex-grow-1 text-muted border" href="{{route('livres.index')}}">
                                Annuler
                            </a>
                            <button type="submit" class="btn btn-primary btn-custom flex-grow-1 shadow">
                                <i class="bi {{ auth()->user()->role === 'adherent' ? 'bi-send-check-fill' : 'bi-check-circle' }} me-1"></i> 
                                {{ auth()->user()->role === 'adherent' ? 'Envoyer ma Demande' : 'Valider l\'Emprunt' }}
                            </button>
                        </div>

                    </form>
                </div>
            </div>

            @if(auth()->user()->role === 'adherent')
                <div class="mt-4 p-3 bg-warning bg-opacity-10 border border-warning border-opacity-25 rounded-4">
                    <p class="small text-warning-emphasis mb-0">
                        <strong>Note :</strong> Votre demande doit être validée par un administrateur lors de la récupération physique du livre à la bibliothèque.
                    </p>
                </div>
            @endif

        </div>
    </div>
</div>

@endsection