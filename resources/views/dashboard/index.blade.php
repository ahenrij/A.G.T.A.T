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
    <div class="row">
        <div class="col s12 m8 l8" style="">
            <div class="card" style="overflow: hidden">
                <div class="card-move-up waves-effect waves-block waves-light">
                    <div class="move-up grey lighten-3">
                        <div>
                            <span class="chart-title grey-text text-darken-1"
                                  style="font-family: Montserrat; font-weight: 400">EVOLUTION DES VENTES</span>
                            <div class="chart-revenue grey-text text-darken-3">
                                <p class="chart-revenue-total"><h4
                                        style="font-family: Montserrat">{{ $nombre_titres }}</h4></p>
                            </div>
                        </div>
                        <div class="trending-line-chart-wrapper">
                            <canvas id="trending-line-chart" height="100"></canvas>
                        </div>
                    </div>
                </div>
                <div class="card-content">
                    <div class="col s12 m3 l3">
                        <div id="doughnut-chart-wrapper">
                            <canvas id="doughnut-chart" height="350"></canvas>
                        </div>
                    </div>
                    <div class="col s12 m3 l3" style="margin-top: 100px">
                        <ul class="doughnut-chart-legend">
                            <li class="mobile ultra-small">
                                <span class="legend-color"></span>
                                <span>Badges - {{ $prcent_badge }} %</span>
                            </li>
                            <li class="kitchen ultra-small">
                                <span class="legend-color"></span>
                                <span>Macarons - {{ $prcent_macaron }} %</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="col s12 m4 l4 waves-effect waves-green" onclick="window.location.href='{{ route('titre.index') }}'">
            <div class="card config-card">
                <div class="card-content green white-text">
                    <p class="card-stats-title"><i class="mdi-social-group-add"></i>Badges</p>
                    <h4 class="card-stats-number" id="nombre_badges">{{ $nombre_badges }}</h4>
                    <div class="right-align" style="margin-right: 5%"><i class="medium material-icons">description</i>
                    </div>
                </div>
                <div class="card-action green darken-2">
                    <a href="{{ route('titre.index') }}" class="white-text"> Liste </a>
                </div>
            </div>
        </div>
        <div class="col s12 m4 l4 waves-effect waves-red" onclick="window.location.href='{{ route('titre.index') }}'">
            <div class="card config-card">
                <div class="card-content pink white-text">
                    <p class="card-stats-title"><i class="mdi-social-group-add"></i>Macarons</p>
                    <h4 class="card-stats-number" id="nombre_macarons">{{ $nombre_macarons }}</h4>
                    <div class="right-align" style="margin-right: 5%"><i class="medium material-icons">description</i>
                    </div>
                </div>
                <div class="card-action pink darken-2 ">
                    <a href="{{ route('titre.index') }}" class="white-text"> Liste </a>
                </div>
            </div>
        </div>
    </div>
    <div id="stats_badges" class="hide">
        @foreach($nombreBadgesByMonth as $ligne)
            <div id="{{ $ligne->mois }}">{{ $ligne->nombre }}</div>
        @endforeach
    </div>
    <div id="stats_macarons" class="hide">
        @foreach($nombreMacaronsByMonth as $ligne)
            <div id="{{ $ligne->mois }}">{{ $ligne->nombre }}</div>
        @endforeach
    </div>
    <!-- chartjs -->
    <script type="text/javascript" src="https://code.jquery.com/jquery-2.2.4.min.js"></script>
    <script type="text/javascript" src="{{URL::to('/')}}/js/chart.min.js"></script>
    <script type="text/javascript" src="{{URL::to('/')}}/js/chart-script.js"></script>
@stop