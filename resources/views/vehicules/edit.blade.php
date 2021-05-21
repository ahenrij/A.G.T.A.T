@extends('layouts.app')

@section('content')

    <nav class="grey lighten-1 menu">
        <div class="nav-wrapper">
            <div class="col s12">
                <a href="{{ route('home') }}" class="breadcrumb"><i class="material-icons">home</i></a>
                <a href="{{ url('configurations') }}" class="breadcrumb">Configurations</a>
                <a href="{{ route('vehicule.index') }}" class="breadcrumb">Véhicules</a>
                <a href="#!" class="breadcrumb">Modifier</a>
            </div>
        </div>
    </nav>


    <div class="row" style="margin-top: 50px">
        <div class="col m8 offset-m2 s12">
            {!! Form::model($vehicule, ['route' => ['vehicule.update', $vehicule->id], 'method' => 'put']) !!}
            <div class="card">
                <div class="card-content">
                    <div class="row">
                        <div class="input-field col m6 s12">
                            <i class="material-icons prefix">mode_edit</i>
                            <?php
                            $class = $errors->has('immatriculation') ? 'invalid validate' : 'validate';
                            echo Form::text('immatriculation', null, ['class' => "$class", 'id' => 'immatriculation']);
                            ?>
                            <label {!! $errors->has('immatriculation') ? 'data-error="'.$errors->first('immatriculation').'"' : '' !!}>
                                Immatriculation</label>
                        </div>
                        <div class="input-field col m6 s12">
                            <i class="material-icons prefix">label_outline</i>
                            <?php
                            $class = $errors->has('marque') ? 'invalid validate' : 'validate';
                            echo Form::text('marque', null, ['class' => "$class", 'id' => 'marque']);
                            ?>
                            <label {!! $errors->has('marque') ? 'data-error="'.$errors->first('marque').'"' : '' !!}>
                                Marque</label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-field col m6 s12">
                            <i class="material-icons prefix">directions_car</i>
                            <?php
                            $class = $errors->has('type_vehicule_id') ? 'invalid validate' : 'validate';
                            echo Form::select('type_vehicule_id', $type_vehicules, null, ['class' => "$class"]);
                            ?>
                            <label {!! $errors->has('type_vehicule_id') ? 'data-error="'.$errors->first('type_vehicule_id').'"' : '' !!}>
                                Type de véhicule</label>
                        </div>
                        <div class="input-field col m6 s12">
                            <i class="material-icons prefix">perm_identity</i>
                            <?php
                            $class = $errors->has('user_id') ? 'invalid validate' : 'validate';
                            echo Form::select('user_id', $users, null, ['class' => "$class"]);
                            ?>
                            <label {!! $errors->has('user_id') ? 'data-error="'.$errors->first('user_id').'"' : '' !!}>
                                Responsable</label>
                        </div>
                    </div>
                </div>
                <div class="card-action right-align grey lighten-5">
                    <a href="{{ route('vehicule.index') }}" class="btn waves-effect waves-light grey">Annuler</a>
                    {!! Form::submit('Enregistrer',['class' => 'btn green lighten-1']) !!}
                </div>
            </div>
        {!! Form::close() !!}
    </div>
    </div>
@stop