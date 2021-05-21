@extends('layouts.app')
@section('content')
    <nav class="grey lighten-1 menu">
        <div class="nav-wrapper truncate">
            <div class="col s12">
                <a href="{{ route('home') }}" class="breadcrumb"><i class="material-icons">home</i></a>
                <a href="{{ url('configurations') }}" class="breadcrumb">Configurations</a>
                <a href="{{ route('structure.index') }}" class="breadcrumb">Structures</a>
                <a href="#!" class="breadcrumb">Modifier</a>
            </div>
        </div>
    </nav>

    <div class="row" style="margin-top: 50px">
        <div class="col s12 m6 offset-m3">
            {!! Form::model($structure, ['route' => ['structure.update', $structure->id], 'method' => 'put']) !!}
            <div class="card">
                <div class="card-content" style="padding-bottom: 0px">
                    <div class="row">
                        <div class="input-field col m12 s12">
                            <i class="material-icons prefix">label_outline</i>
                            <?php
                            $class = $errors->has('raison_sociale') ? 'invalid validate' : 'validate';
                            echo Form::text('raison_sociale', null, ['class' => "$class"]);
                            ?>
                            <label for="raison_sociale"
                                    {!! $errors->has('raison_sociale') ? 'data-error="'.$errors->first('raison_sociale').'"' : '' !!}>
                                Raison sociale</label>
                        </div>
                    </div>

                    <div class="row">
                        <div class="input-field col m12 s12">
                            <i class="material-icons prefix">phone</i>
                            <?php
                            $class = $errors->has('contact') ? 'invalid validate' : 'validate';
                            echo Form::text('contact', null, ['class' => "$class"]);
                            ?>
                            <label for="contact"
                                    {!! $errors->has('contact') ? 'data-error="'.$errors->first('contact').'"' : '' !!}>
                                Contact</label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-field col m12 s12">
                            <i class="material-icons prefix">domain</i>
                            <?php
                            $class = $errors->has('adresse') ? 'invalid validate' : 'validate';
                            echo Form::text('adresse', null, ['class' => "$class"]);
                            ?>
                            <label for="adresse"
                                    {!! $errors->has('adresse') ? 'data-error="'.$errors->first('adresse').'"' : '' !!}>
                                Adresse</label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-action right-align grey lighten-5">
                <a href="{{ route('structure.index') }}" class="btn waves-effect waves-light grey">Annuler</a>
                {!! Form::submit('Enregistrer',['class' => 'btn green lighten-1']) !!}
            </div>
        </div>
    </div>
    </div>
    {!! Form::close() !!}
@stop
