@extends('layouts.app')

@section('content')
    <nav class="grey lighten-1 menu">
        <div class="nav-wrapper">
            <div class="col s12">
                <a href="{{ route('home') }}" class="breadcrumb"><i class="material-icons">home</i></a>
                <a href="{{ url('caisse') }}" class="breadcrumb">Caisse</a>
            </div>
        </div>
    </nav>

    @if(session()->has('ok'))
        <script type="text/javascript">
            var message = "{{ session('ok') }}";
            window.onload = function () {
                Materialize.toast(message, 4000);
            };
        </script>
    @endif

    <br>
    <div class="row">
        <div class="col s6 m6 l6">
            @if(!caisseIsClosed())
                <a class="btn waves-effect waves-light btn-large red" href="{{ route('caisse.close') }}">
                    <i class="material-icons right">close</i>Fermer la caisse
                </a>
            @else
                <a class="btn waves-effect waves-light btn-large red lighten-3">
                    <i class="material-icons right">info</i>La caisse a été fermée
                </a>
            @endif
        </div>
    </div>

    <div class="row">
        <div class="col s12 m6 l6 waves-effect">
            <div class="card config-card">
                <div class="card-content green white-text">
                    <p class="card-stats-title"><i class="mdi-social-group-add"></i>RECETTE DU JOUR</p>
                    <h5 class="card-stats-number">{{ number_format($total_jour*1.18) . '    FCFA' }}</h5>
                    <div class="right-align" style="margin-right: 5%"><i class="material-icons medium">attach_money</i>
                    </div>
                </div>
                <div class="card-action green darken-2 ">
                    <br>
                </div>
            </div>
        </div>
        <div class="col s12 m6 l6 waves-effect">
            <div class="card config-card">
                <div class="card-content blue white-text">
                    <p class="card-stats-title"><i class="mdi-social-group-add"></i>RECETTE ANNUELLE</p>
                    <h5 class="card-stats-number">{{ number_format($total_annee*1.18) . '    FCFA' }}</h5>
                    <div class="right-align" style="margin-right: 5%"><i class="material-icons medium">attach_money</i>
                    </div>
                </div>
                <div class="card-action blue darken-2 ">
                    <br>
                </div>
            </div>
        </div>
    </div>
@stop
