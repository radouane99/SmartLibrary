@extends('layouts._pageLayout')
@section('content')
    <div class="card text-center">
        <div class="card-header">
        {{$theme->intitule}}
        </div>
        <div class="card-body">
        <h5 class="card-title">{{$theme->intitule}}</h5>
        {{-- <p class="card-text">
            Auteur : {{$theme->auteur}}
            <br>
            Nombre des Exemplaires : {{$theme->nbExemplaire}}
        </p> --}}
        <a href="{{route('themes.index')}}" class="btn btn-primary">Retour</a>
        </div>
        <div class="card-footer text-muted">
            @if(request('sup')!=null)
                <form action="{{route('themes.destroy',$theme->id)}}" method="post">
                    @csrf
                    @method('DELETE')
                    <input class="btn btn-danger" type="submit" value="Supprimer"/>
                </form>
            @endif
        </div>
    </div>
@endsection