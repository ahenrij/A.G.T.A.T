@extends('layouts.app')

@section('content')

    <nav class="grey lighten-1 menu">
        <div class="nav-wrapper">
            <div class="col s12">
                <a href="{{ route('user.index') }}" class="breadcrumb">Utilisateurs</a>
                <a href="{{ route('user.index') }}" class="breadcrumb">Liste des utilisateurs</a>
                <a href="#!" class="breadcrumb">Modifier utilisateur</a>
            </div>
        </div>
    </nav>

    <div class="row">
        <div class="col s12">
            {!! Form::model($user, ['route' => ['user.update', $user->id], 'method' => 'put', 'class' => 'col s12','files' => true]) !!}
            <div class="card">
                <div class="card-content">
                    <div class="row">
                        <div class="row">
                            <div class="input-field col m6 s6">
                                {{--<i class="material-icons prefix grey-text">image</i>--}}
                                <p class="small grey-text text-darken-1" style="margin-bottom: 10px">Photo de profil</p>
                                <label {!! $errors->has('profil') ? 'data-error="'.$errors->first('profil').'"' : '' !!}></label>
                                <input id="profil" name="profil" type="file"
                                       class="{{  $errors->has('profil') ? 'invalid validate' : 'validate' }} hide"/>
                                <img id="preview" class="grey lighten-2 card hoverable" title="Cliquez pour modifier"
                                     onclick="$('#profil').click()" style="height: 150px; width: 150px"
                                     src="{{ profil_link($user->profil) }}" alt="Photo de profil"/>
                            </div>
                        </div>

                        <div class="row">
                            <div class="input-field col m6 s12" style="margin-bottom: 0px">
                                <i class="material-icons prefix">person_outline</i>
                                <?php
                                $class = $errors->has('nom') ? 'invalid validate' : 'validate';
                                echo Form::text('nom', null, ['class' => "$class"]);
                                ?>
                                <label for="nom"
                                        {!! $errors->has('nom') ? 'data-error="'.$errors->first('nom').'"' : '' !!}>
                                    Nom</label>
                            </div>

                            <div class="input-field col m6 s12">
                                <i class="material-icons prefix"></i>
                                <?php
                                $class = $errors->has('prenom') ? 'invalid validate' : 'validate';
                                echo Form::text('prenom', null, ['class' => "$class"]);
                                ?>
                                <label for="prenom"
                                        {!! $errors->has('prenom') ? 'data-error="'.$errors->first('prenom').'"' : '' !!}>
                                    Prénoms</label>
                            </div>
                        </div>

                        <div class="row">
                            <div class="input-field col m6 s12">
                                <i class="material-icons prefix">work_outline</i>
                                <?php
                                $class = $errors->has('fonction') ? 'invalid validate' : 'validate';
                                echo Form::text('fonction', null, ['class' => "$class", 'id' => 'fonction']);
                                ?>
                                <label for="fonction" {!! $errors->has('fonction') ? 'data-error="'.$errors->first('fonction').'"' : '' !!}>
                                    Fonction</label>
                            </div>
                            <div class="input-field col m6 s12">
                                <i class="material-icons prefix">business</i>
                                <?php
                                $class = $errors->has('structure_id') ? 'invalid validate' : 'validate';
                                echo Form::select('structure_id', $structures, null, ['class' => "$class"]);
                                ?>
                                <label {!! $errors->has('structure_id') ? 'data-error="'.$errors->first('structure_id').'"' : '' !!}>
                                    Structure</label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="input-field col m6 s12">
                                <i class="material-icons prefix">phone</i>
                                <?php
                                $class = $errors->has('telephone') ? 'invalid validate' : 'validate';
                                echo Form::text('telephone', null, ['class' => "$class", 'id' => 'telephone']);
                                ?>
                                <label for="telephone" {!! $errors->has('telephone') ? 'data-error="'.$errors->first('telephone').'"' : '' !!}>
                                    Téléphone</label>
                            </div>
                            <div class="input-field col m6 s12">
                                <i class="material-icons prefix">verified_user</i>
                                <?php
                                $class = $errors->has('login') ? 'invalid validate' : 'validate';
                                echo Form::text('login', null, ['class' => "$class", 'id' => 'login']);
                                ?>
                                <label for="login" {!! $errors->has('login') ? 'data-error="'.$errors->first('login').'"' : '' !!}>
                                    Login</label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="input-field col m6 s12">
                                <i class="material-icons prefix">portrait</i>
                                <?php
                                $class = $errors->has('type_user_id') ? 'invalid validate' : 'validate';
                                echo Form::select('type_user_id', $type_users, null, ['class' => "$class"]);
                                ?>
                                <label {!! $errors->has('type_user_id') ? 'data-error="'.$errors->first('type_user_id').'"' : '' !!}>
                                    Type d'utilisateur</label>
                            </div>
                            <div class="input-field col m6 s12">
                                <i class="material-icons prefix">people</i>
                                <?php
                                $class = $errors->has('groupe_id') ? 'invalid validate' : 'validate';
                                echo Form::select('groupe_id', $groupes, null, ['class' => "$class"]);
                                ?>
                                <label {!! $errors->has('groupe_id') ? 'data-error="'.$errors->first('groupe_id').'"' : '' !!}>
                                    Groupe</label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="input-field col m6 s12">
                                <i class="material-icons prefix">lock_outline</i>
                                <?php
                                $class = $errors->has('password') ? 'invalid validate' : 'validate';
                                echo Form::password('password', ['class' => "$class", 'id'=>'password']);
                                ?>
                                <label for="password" {!! $errors->has('password') ? 'data-error="'.$errors->first('password').'"' : '' !!}>
                                    Nouveau mot de passe</label>
                            </div>

                            <div class="input-field col m6 s12">
                                <i class="material-icons prefix"></i>
                                {{ Form::password('password_confirmation', ['class' => 'validate', 'id'=>'password_confirmation']) }}
                                <label for="password_confirmation">Confirmation mot de passe</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-action right-align grey lighten-5">
                    <a href="{{ route('user.index') }}" class="btn waves-effect waves-light grey">Annuler</a>
                    {!! Form::submit('Modifier', ['class' => 'btn green lighten-1']) !!}
                </div>
            </div>
        </div>
    </div>

@endsection