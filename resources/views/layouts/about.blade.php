<!DOCTYPE html>
<html>
<head>
    <title>A propos</title>

    {!! Html::style(URL::to('/').'/css/materialize.css') !!}
    {!! Html::style('https://fonts.googleapis.com/icon?family=Material+Icons') !!}
    {!! Html::style('https://fonts.googleapis.com/css?family=Montserrat:100') !!}

    <meta charset="utf-8">

    <style>
        html, body {
            height: 100%;
        }
        .container {
            position: absolute;
            top: 30%;
            left: 50%;
            transform: translate(-50%, -50%)
        }
    </style>
</head>
<body>
<div class="container">
    <div class="content">
        <div class="row">
            <div class="col s12 m12 ">
                <div class="card blue-grey darken-2">
                    <div class="card-content white-text">
                        <span class="card-title" style="font-family: 'Montserrat ExtraLight'">A propos</span>
                        <h4 class="orange-text">Application de Gestion des Titres d'Accès Temporaire</h4>
                        <p class="small">&copy; Port Autonome de Cotonou 2018<br/>Tous droits réservés.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>
