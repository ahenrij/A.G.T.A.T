@extends('layouts.app')

@section('content')
    <nav class="grey lighten-1 menu">
        <div class="nav-wrapper">
            <div class="col s12">
                <a href="{{ route('home') }}" class="breadcrumb"><i class="material-icons">home</i></a>
                <a href="#!" class="breadcrumb">Tableau de bord</a>
            </div>
        </div>
    </nav>

    <div class="row config-row">
        <a href="#" class="white-text">
            <div class="col s12 m8 l4 waves-effect waves-orange">
                <div class="card config-card">
                    <div class="card-content orange white-text">
                        <p class="card-stats-title"><i class="mdi-social-group-add"></i>Demandes en cours</p>
                        <h4 class="card-stats-number">{{ $nombre_demandes_encours}}</h4>
                        <div class="right-align" style="margin-right: 5%"><i class="material-icons">description</i>
                        </div>
                    </div>
                    <div class="card-action orange darken-2 ">
                        {{--<p> Afficher la liste </p>--}}
                    </div>
                </div>
            </div>
        </a>
        <a href="#" class="white-text">
            <div class="col s12 m8 l4 waves-effect waves-green">
                <div class="card config-card">
                    <div class="card-content green white-text">
                        <p class="card-stats-title"><i class="mdi-social-group-add"></i>Demandes validées</p>
                        <h4 class="card-stats-number">{{ $nombre_demandes_validees }}</h4>
                        <div class="right-align" style="margin-right: 5%"><i class="material-icons">description</i>
                        </div>
                    </div>
                    <div class="card-action green darken-2 ">
                        {{--<p> Afficher la liste </p>--}}
                    </div>
                </div>
            </div>
        </a>
        <a href="#" class="white-text">
            <div class="col s12 m8 l4 waves-effect waves-cyan">
                <div class="card config-card">
                    <div class="card-content cyan white-text">
                        <p class="card-stats-title"><i class="mdi-social-group-add"></i>Titres</p>
                        <h4 class="card-stats-number">{{ $nombre_titres_achetes }}</h4>
                        <div class="right-align" style="margin-right: 5%"><i class="material-icons">description</i>
                        </div>
                    </div>
                    <div class="card-action cyan darken-2 ">
                        {{--<p> Afficher la liste </p>--}}
                    </div>
                </div>
            </div>
        </a>
    </div>


@endsection