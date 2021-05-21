@extends('layouts.app')

@section('content')

    <nav class="grey lighten-1 menu">
        <div class="nav-wrapper">
            <div class="col s12">
                <a href="{{ route('home') }}" class="breadcrumb"><i class="material-icons">home</i></a>
                <a href="{{ url('configurations') }}" class="breadcrumb">Configurations</a>
                <a href="{{ route('vehicule.index') }}" class="breadcrumb">Vehicules</a>
                <a href="#!" class="breadcrumb">Fiche n°{{ $vehicule->immatriculation }}</a>
            </div>
        </div>
    </nav>

    <div class="row" style="margin-top: 50px">
        <div class="col s12 m6 offset-m3">
            <div class="card">
                <div class="card-content">
                    <h4>{{ $vehicule->immatriculation }}</h4><br>
                    <p><b>Marque : </b>{{ $vehicule->marque }}</p><br>
                    <p><b>Type de véhicule : </b>{{ $vehicule->typeVehicule->libelle }}</p><br>
                    <p><b>Responsable : </b>{{ $vehicule->user->prenom.' '.$vehicule->user->nom }}</p><br>
                    <p><b>Tel. responsable : </b>{{ $vehicule->user->telephone }}</p><br>
                </div>
                <div class="card-action right-align grey lighten-5">
                    <a href="{{ route('vehicule.edit', [$vehicule->id]) }}">Modifier</a>
                    <a href="#!" onclick="$('#del_vehicule{{ $vehicule->id }}').click();">Supprimer</a>
                    {!! Form::open(['method' => 'DELETE', 'route' => ['vehicule.destroy', $vehicule->id]]) !!}
                    {!! Form::submit('Supprimer', ['id'=>'del_vehicule'.$vehicule->id,'class' => 'hide', 'onclick' => 'return confirm(\'Vraiment supprimer ce véhicule ?\')']) !!}
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection