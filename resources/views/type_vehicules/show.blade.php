@extends('layouts.app')

@section('content')

    <nav class="grey lighten-1 menu">
        <div class="nav-wrapper">
            <div class="col s12">
                <a href="{{ route('typevehicule.index') }}" class="breadcrumb">Types vehicules</a>
                <a href="{{ route('typevehicule.index') }}" class="breadcrumb">Liste des types vehicules</a>
                <a href="#!" class="breadcrumb">Fiche des types vehicules</a>
            </div>
        </div>
    </nav>

    <div class="row" style="margin-top: 50px">
        <div class="col m4 offset-m4">
            <div class="card-panel">
                <h5>Fiche type vehicules</h5>
                <p><b>Libellé :</b> {{ $typevehicule->libelle }}</p>
            </div>
            <a href="javascript:history.back()" class="btn center">Retour</a>
        </div>
    </div>
@endsection