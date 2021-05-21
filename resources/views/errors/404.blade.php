<!DOCTYPE html>
<html>
<head>
    <title>404.</title>

    <link href="https://fonts.googleapis.com/css?family=Lato:100" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Roboto:100" rel="stylesheet" type="text/css">
    {!! Html::style(URL::to('/').'/css/materialize.css') !!}
    {!! Html::style('https://fonts.googleapis.com/icon?family=Material+Icons') !!}

    <meta charset="utf-8">

    <style>
        html, body {
            height: 100%;
        }

        body {
            margin: 0;
            padding: 0;
            width: 100%;
            color: #616161;
            display: table;
            font-weight: 100;
        }

        .container {
            text-align: center;
            display: table-cell;
            vertical-align: middle;
        }

        .content {
            text-align: center;
            display: inline-block;
        }

        .text{
            font-size: 22px;
            color: #808080;
        }

        .title {
            font-size: 72px;
            margin-bottom: 30px;
            font-family: 'Roboto';
        }
    </style>
</head>
<body>
<div class="container">
    <div class="content">
        <div class="title">Erreur 404 !</div>
        <div class="text">La page que vous essayez de consulter n'existe pas ou a été retirée.</div>
        <br>
        <br>
        <button class="btn grey darken-1" onclick="javascript:history.back()"><i class="material-icons left">chevron_left</i>Retour</button>
    </div>
</div>
</body>
</html>
