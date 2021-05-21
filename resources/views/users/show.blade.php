@extends('layouts.app')

@section('content')

    <nav class="grey lighten-1 menu">
        <div class="nav-wrapper">
            <div class="col s12">
                <a href="{{ route('user.index') }}" class="breadcrumb">Utilisateurs</a>
                <a href="{{ route('user.index') }}" class="breadcrumb">Liste des utilisateurs</a>
                <a href="#!" class="breadcrumb">Fiche utilisateur</a>
            </div>
        </div>
    </nav>

    <div class="row" style="margin-top: 50px">
        <div class="col s12 m10 offset-m1">
            <div class="card horizontal">
                <div class="card-image">
                    <img src="{{ profil_link($user->profil) }}" class="grey lighten-2" style="width: 450px; height: 100%">
                </div>
                <div class="card-stacked">
                    <div class="card-content">
                        <h4> {{ $user->prenom.' '.$user->nom }}</h4><br>
                        <p><b>Fonction :</b> {{ $user->fonction }}</p><br>
                        <p><b>Téléphone :</b> {{ $user->telephone }}</p><br>
                        <p><b>Login :</b> {{ $user->login }}</p><br>
                        <p><b>Structure :</b> {{ $user->structure->raison_sociale }}</p><br>
                        <p><b>Type d'utilisateur :</b> {{ $user->typeUser->libelle }}</p><br>
                        <p><b>Groupe :</b> {{ $user->groupe->libelle }}</p><br>
                    </div>
                    <div class="card-action right-align grey lighten-5">
                        <a href="{{ route('user.edit', [$user->id]) }}">Modifier</a>
                        <a href="#!" onclick="$('#del_user{{ $user->id }}').click();">Supprimer</a>
                        {!! Form::open(['method' => 'DELETE', 'route' => ['user.destroy', $user->id]]) !!}
                        {!! Form::submit('Supprimer', ['id'=>'del_user'.$user->id,'class' => 'hide', 'onclick' => 'return confirm(\'Vraiment supprimer cet utilisateur ?\')']) !!}
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection