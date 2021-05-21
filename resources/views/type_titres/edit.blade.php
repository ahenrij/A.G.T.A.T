@extends('layouts.app')

@section('content')

    <nav class="grey lighten-1 menu">
        <div class="nav-wrapper truncate">
            <div class="col s12">
                <a href="{{ route('home') }}" class="breadcrumb"><i class="material-icons">home</i></a>
                <a href="{{ url('configurations') }}" class="breadcrumb">Configurations</a>
                <a href="{{ route('typetitre.index') }}" class="breadcrumb">Types de titres</a>
                <a href="#!" class="breadcrumb">Modifier</a>
            </div>
        </div>
    </nav>

    <div class="row" style="margin-top: 50px">
        <div class="col s12 m6 offset-m3">
            {!! Form::model($typetitre, ['route' => ['typetitre.update', $typetitre->id], 'method' => 'put']) !!}
            <div class="card">
                <div class="card-content" style="padding-bottom: 0px">
                    <div class="row">
                        <div class="input-field col s12">
                            <i class="material-icons prefix">label_outline</i>
                            <?php
                            $class = $errors->has('libelle') ? 'invalid validate' : 'validate';
                            echo Form::text('libelle', null, ['class' => "$class", 'id' => 'libelle']);
                            ?>
                            <label {!! $errors->has('libelle') ? 'data-error="'.$errors->first('libelle').'"' : '' !!}>
                                Libellé</label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-field col s12">
                            <i class="material-icons prefix">edit</i>
                            <?php
                            $class = $errors->has('duree') ? 'invalid validate' : 'validate';
                            echo Form::number('duree', null, ['class' => "$class", 'step' => '24', 'id' => 'duree']);
                            ?>
                            <label {!! $errors->has('duree') ? 'data-error="'.$errors->first('duree').'"' : '' !!}>
                                Durée : en heures</label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-field col s12">
                            <i class="material-icons prefix">euro_symbol</i>
                            <?php
                            $class = $errors->has('prix') ? 'invalid validate' : 'validate';
                            echo Form::number('prix', null, ['class' => "$class", 'id' => 'prix']);
                            ?>
                            <label {!! $errors->has('prix') ? 'data-error="'.$errors->first('prix').'"' : '' !!}>
                                Prix</label>
                        </div>
                    </div>
                </div>
                <div class="card-action right-align grey lighten-5">
                    <a href="{{ route('typetitre.index') }}" class="btn waves-effect waves-light grey">Annuler</a>
                    {!! Form::submit('Enregistrer',['class' => 'btn green lighten-1']) !!}
                </div>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
@stop