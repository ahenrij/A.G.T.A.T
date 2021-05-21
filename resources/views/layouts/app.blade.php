<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>AGTAT - Application de Gestion de Titres d'Accès Temporaires</title>

    <!-- Fonts -->
    {!! Html::style('https://fonts.googleapis.com/css?family=Montserrat:400,700') !!}
    {!! Html::style('https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css') !!}
    {!! Html::style('https://fonts.googleapis.com/css?family=Source+Sans+Pro:400,300,600') !!}
    {!! Html::style('https://fonts.googleapis.com/css?family=Lato:100') !!}
    {!! Html::style('https://fonts.googleapis.com/css?family=Montserrat:100') !!}

    <!-- Styles -->


    {!! Html::style(URL::to('/').'/css/chart.css') !!}
    {!! Html::style(URL::to('/').'/css/layouts/layout-2.min.css') !!}
    {!! Html::style(URL::to('/').'/css/layouts/layout-3.min.css') !!}
    {!! Html::style(URL::to('/').'/css/layouts/style-fullscreen.css') !!}
    {!! Html::style(URL::to('/').'/css/layouts/style-horizontal.css') !!}
    <link href="{!! URL::to('/').'/css/export.css' !!}" rel="stylesheet" type="text/css"  media="print" />

    {!! Html::style('https://fonts.googleapis.com/icon?family=Material+Icons') !!}
    {!! Html::style(URL::to('/').'/css/materialize.css') !!}
    {!! Html::style(URL::to('/').'/css/dataTables.bootstrap.css') !!}
    {!! Html::style(URL::to('/').'/css/style.css') !!}
    <link href="{!! URL::to('/').'/css/bootstrap.min.css' !!}" rel="stylesheet" type="text/css" media="print"/>
    <link href="{!! URL::to('/').'/css/print.css' !!}" rel="stylesheet" type="text/css" media="print"/>
    @if (Auth::guest())
        {{--<script src='https://www.google.com/recaptcha/api.js' type="text/javascript"></script>--}}
    @endif
</head>

<body id="app-layout">
    @if (Auth::guest())

        @yield('content')

    @else
        @if(!session()->has('auth_notified'))
            {{ session(['auth_notified'=> true ]) }}
            <script type="text/javascript">
                var username = "<?php echo Auth::user()->prenom; ?>";
                window.onload = function () {
                    Materialize.toast('Content de vous revoir ' + username + ' !', 4000);
                };
            </script>
        @endif
        <nav class="blue-grey darken-2 z-depth-2 hidden-print" >
            <div class="nav-wrapper">
                <header>
                <ul id="slide-out" class="side-nav fixed">
                    @include('layouts.header')
                    @include('layouts.menu')
                </ul>
                </header>
                @include('layouts.navbar')
            </div>
        </nav>

        <main>
            @yield('content')
        </main>
    @endif

    <!-- JavaScripts -->
    <script type="text/javascript" src="{{URL::to('/')}}/js/jquery.min.js"></script>
    <script type="text/javascript" src="{{URL::to('/')}}/js/jquery.dataTables.js"></script>
    <script type="text/javascript" src="{{URL::to('/')}}/js/dataTables.bootstrap.js"></script>
    <script type="text/javascript" src="{{URL::to('/')}}/js/materialize.min.js"></script>
    <script type="text/javascript" src="{{URL::to('/')}}/js/skrypt.js"></script>

    <script type="text/javascript" src="{{URL::to('/')}}/js/script.js"></script>
</body>
</html>
