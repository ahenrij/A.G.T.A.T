@extends('layouts.app')

@section('content')

    <nav class="grey lighten-1 menu">
        <div class="nav-wrapper truncate">
            <div class="col s12">
                <a href="{{ route('home') }}" class="breadcrumb"><i class="material-icons">home</i></a>
                <a href="{{ url('configurations') }}" class="breadcrumb">Configurations</a>
                <a href="{{ route('zone.index') }}" class="breadcrumb">Zones</a>
                <a href="#!" class="breadcrumb">Modifier</a>
            </div>
        </div>
    </nav>

    <div class="row" style="margin-top: 50px">
        <div class="col s12 m6 offset-m3">
            {!! Form::model($zone, ['route' => ['zone.update', $zone->id], 'method' => 'put']) !!}
            <div class="card">
                <div class="card-content" style="padding-bottom: 0px">
                    <div class="row">
                        <div class="input-field col m12 s12">
                            <i class="material-icons prefix">mode_edit</i>
                            <?php
                            $class = $errors->has('libelle') ? 'invalid validate' : 'validate';
                            echo Form::text('libelle', null, ['class' => "$class"]);
                            ?>
                            <label for="libelle"
                                    {!! $errors->has('libelle') ? 'data-error="'.$errors->first('libelle').'"' : '' !!}>
                                Libellé</label>
                        </div>
                    </div>
                </div>
                <div class="card-action right-align grey lighten-5">
                    <a href="{{ route('zone.index') }}" class="btn waves-effect waves-light grey">Annuler</a>
                    {!! Form::submit('Enregistrer',['class' => 'btn green lighten-1']) !!}
                </div>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
@stop