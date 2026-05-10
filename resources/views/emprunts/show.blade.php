@extends('layouts._pageLayout')
@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="premium-card shadow-lg">
                <div class="premium-card-header d-flex justify-content-between align-items-center">
                    <h5 class="fw-bold mb-0">🏷️ Détails de l'Emprunt #{{$emprunt->id}}</h5>
                    <a href="{{route('emprunts.index')}}" class="btn btn-sm btn-outline-secondary btn-custom">
                        <i class="bi bi-arrow-left"></i> Retour
                    </a>
                </div>
                
                <div class="premium-card-body">
                    <div class="row g-4">
                        <div class="col-md-6">
                            <h6 class="text-muted small text-uppercase fw-bold mb-3">Information Livre</h6>
                            <div class="d-flex align-items-start gap-3 mb-3">
                                <div class="bg-primary bg-opacity-10 text-primary p-3 rounded-4">
                                    <i class="bi bi-book fs-3"></i>
                                </div>
                                <div>
                                    <h5 class="fw-bold mb-1">{{$emprunt->livre->titre}}</h5>
                                    <p class="text-muted mb-0">Auteur: {{$emprunt->livre->auteur}}</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <h6 class="text-muted small text-uppercase fw-bold mb-3">Emprunteur</h6>
                            <div class="d-flex align-items-center gap-3">
                                <img src="{{ asset('storage/' . $emprunt->user->photo) }}" class="rounded-circle" style="width: 50px; height: 50px; object-fit: cover;">
                                <div>
                                    <h6 class="fw-bold mb-0">{{$emprunt->user->name}}</h6>
                                    <small class="text-muted">{{$emprunt->user->email}}</small>
                                </div>
                            </div>
                        </div>
                    </div>

                    <hr class="my-4 opacity-50">

                    <div class="row g-4">
                        <div class="col-md-6 text-center p-3 border-end">
                            <p class="text-muted mb-1">Date d'Emprunt</p>
                            <h5 class="fw-bold text-primary">{{ \Carbon\Carbon::parse($emprunt->dateEmp)->format('d M Y') }}</h5>
                        </div>
                        <div class="col-md-6 text-center p-3">
                            <p class="text-muted mb-1">Date de Retour Prévue</p>
                            <h5 class="fw-bold text-dark">{{ \Carbon\Carbon::parse($emprunt->dateRetour)->format('d M Y') }}</h5>
                        </div>
                    </div>

                    {{-- FORMULAIRE D'AVIS (Seulement pour l'adhérent qui possède le livre) --}}
                    @if(auth()->check() && auth()->user()->id == $emprunt->user_id)
                    <div class="mt-5 p-4 bg-light rounded-4 border">
                        <h6 class="fw-bold mb-3"><i class="bi bi-star-fill text-warning me-2"></i>Laissez votre avis sur ce livre</h6>
                        <form action="{{ route('emprunts.update', $emprunt->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            
                            <div class="mb-3">
                                <label class="form-label small fw-bold">Votre Note (1 à 5)</label>
                                <div class="rating-group d-flex gap-3">
                                    @for($i=1; $i<=5; $i++)
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="note" id="star{{$i}}" value="{{$i}}" {{ $emprunt->note == $i ? 'checked' : '' }}>
                                        <label class="form-check-label" for="star{{$i}}">{{$i}} ⭐</label>
                                    </div>
                                    @endfor
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label small fw-bold">Votre Commentaire</label>
                                <textarea name="commentaire" class="form-control" rows="3" placeholder="Qu'avez-vous pensé de ce livre ?">{{ $emprunt->commentaire }}</textarea>
                            </div>

                            <button type="submit" class="btn btn-primary btn-custom w-100 shadow-sm">
                                <i class="bi bi-send-fill me-1"></i> Enregistrer mon avis
                            </button>
                        </form>
                    </div>
                    @endif

                    {{-- BOUTON DE SUPPRESSION (Si demandé par l'admin) --}}
                    @if(request('sup') != null)
                    <div class="mt-4 p-4 border border-danger bg-danger bg-opacity-10 rounded-4 text-center">
                        <h6 class="text-danger fw-bold mb-3">⚠️ Zone de Danger</h6>
                        <p class="small text-muted mb-3">Confirmez-vous le retour (ou la suppression) de cet emprunt ?</p>
                        <form action="{{route('emprunts.destroy',$emprunt->id)}}" method="post">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-custom px-5">
                                <i class="bi bi-trash-fill me-1"></i> Confirmer la Suppression
                            </button>
                        </form>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection