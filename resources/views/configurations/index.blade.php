@extends('layouts.app')
@section('content')
    <nav class="grey lighten-1 menu">
        <div class="nav-wrapper">
            <div class="col s12">
                <a href="{{ route('home') }}" class="breadcrumb"><i class="material-icons">home</i></a>
                <a href="{{ url('configurations') }}" class="breadcrumb">Configurations</a>
            </div>
        </div>
    </nav>
    <div class="row config-row">
        <div class="col s12 m6 l3 waves-effect waves-green" onclick="window.location.href='{{ route('zone.index') }}'">
            <div class="card config-card">
                <div class="card-content green white-text">
                    <p class="card-stats-title"><i class="mdi-social-group-add"></i>Zones</p>
                    <h4 class="card-stats-number">{{ $nombre_zone }}</h4>
                    <div class="right-align" style="margin-right: 5%"><i class="material-icons">location_on</i>
                    </div>
                </div>
                <div class="card-action green darken-2 ">
                    <a href="{{ route('zone.index') }}" class="white-text"> Afficher la liste </a>
                </div>
            </div>
        </div>
        <div class="col s12 m6 l3 waves-effect waves-purple"
             onclick="window.location.href='{{ route('vehicule.index') }}'">
            <div class="card config-card">
                <div class="card-content purple white-text">
                    <p class="card-stats-title"><i class="mdi-social-group-add"></i>Véhicules</p>
                    <h4 class="card-stats-number">{{ $nombre_vehicule }}</h4>
                    <div class="right-align" style="margin-right: 5%"><i class="material-icons">drive_eta</i>
                    </div>
                </div>
                <div class="card-action purple darken-2 ">
                    <a href="{{ route('vehicule.index') }}" class="white-text"> Afficher la liste </a>
                </div>
            </div>
        </div>
        <div class="col s12 m6 l3 waves-effect waves-brown"
             onclick="window.location.href='{{ route('groupe.index') }}'">
            <div class="card config-card">
                <div class="card-content brown white-text">
                    <p class="card-stats-title"><i class="mdi-social-group-add"></i>Groupes</p>
                    <h4 class="card-stats-number">{{ $nombre_groupe }}</h4>
                    <div class="right-align" style="margin-right: 5%"><i class="material-icons">group</i>
                    </div>
                </div>
                <div class="card-action brown darken-2 ">
                    <a href="{{ route('groupe.index') }}" class="white-text"> Afficher la liste </a>
                </div>
            </div>
        </div>
        <div class="col s12 m6 l3 waves-effect waves-orange"
             onclick="window.location.href='{{ route('structure.index') }}'">
            <div class="card config-card">
                <div class="card-content orange white-text">
                    <p class="card-stats-title"><i class="mdi-social-group-add"></i>Structures</p>
                    <h4 class="card-stats-number">{{ $nombre_structure }}</h4>
                    <div class="right-align" style="margin-right: 5%"><i class="material-icons">domain</i>
                    </div>
                </div>
                <div class="card-action orange darken-2 ">
                    <a href="{{ route('structure.index') }}" class="white-text"> Afficher la liste </a>
                </div>
            </div>
        </div>
        <div class="col s12 m6 l3 waves-effect waves-grey"
             onclick="window.location.href='{{ route('typetitre.index') }}'">
            <div class="card config-card">
                <div class="card-content grey white-text">
                    <p class="card-stats-title"><i class="mdi-social-group-add"></i>Types de titres</p>
                    <h4 class="card-stats-number">{{ $nombre_ttitre }}</h4>
                    <div class="right-align" style="margin-right: 5%"><i class="material-icons">description</i>
                    </div>
                </div>
                <div class="card-action grey darken-2 ">
                    <a href="{{ route('typetitre.index') }}" class="white-text"> Afficher la liste </a>
                </div>
            </div>
        </div>
        <div class="col s12 m6 l3 waves-effect" onclick="window.location.href='{{ route('typevehicule.index') }}'">
            <div class="card config-card">
                <div class="card-content cyan white-text">
                    <p class="card-stats-title"><i class="mdi-social-group-add"></i>Types de véhicules</p>
                    <h4 class="card-stats-number">{{ $nombre_tvehicule }}</h4>
                    <div class="right-align" style="margin-right: 5%"><i class="material-icons">drive_eta</i>
                    </div>
                </div>
                <div class="card-action cyan darken-2 ">
                    <a href="{{ route('typevehicule.index') }}" class="white-text"> Afficher la liste </a>
                </div>
            </div>
        </div>
        <div class="col s12 m6 l3 waves-effect waves-red"
             onclick="window.location.href='{{ route('typeuser.index') }}'">
            <div class="card config-card">
                <div class="card-content pink white-text">
                    <p class="card-stats-title"><i class="mdi-social-group-add"></i>Types d'utilisateurs</p>
                    <h4 class="card-stats-number">{{ $nombre_tuser }}</h4>
                    <div class="right-align" style="margin-right: 5%"><i class="material-icons">person</i>
                    </div>
                </div>
                <div class="card-action pink darken-2 ">
                    <a href="{{ route('typeuser.index') }}" class="white-text"> Afficher la liste </a>
                </div>
            </div>
        </div>
    </div>
@stop