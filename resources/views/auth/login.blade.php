@extends('layouts.app')

@section('content')

    <!--    --><?php //session('recaptcha_error'); ?>

    {{ session()->forget('auth_notified') }}
    <div class="container" style="margin-top:8%">
        <div class="row">
            <div class="col s12 m8 offset-m2 card horizontal grey lighten-5 z-depth-2" style="padding: 0px">

                <div class="card-stacked col m5 s12">
                    <div class="card-content">
                        <span class="card-title grey-text text-darken-1" style="font-size: 2em; margin-bottom: 8px">Connexion</span>
                        <span class="grey-text text-lighten-1" style="font-size: 1em;">
                            Connectez-vous à votre compte !
                        </span>
                        <br><br>
                        <form class="col s12" method="POST" action="{{ url('/login') }}">
                            {{ csrf_field() }}
                            <div class="row">
                                <div class="input-field">
                                    <i class="material-icons prefix">person_outline</i>
                                    <input id="login" name="login" type="text"
                                           class="{{ $errors->has('login') ? 'invalid validate' : 'validate' }}"
                                           value="{{ old('login') }}" required/>
                                    <label for="login"
                                           {!! $errors->has('login') ? 'data-error="'.$errors->first('login').'"' : ''
                                        !!}>
                                        Nom d'utilisateur</label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="input-field">
                                    <i class="material-icons prefix">lock_outline</i>
                                    <input id="password" type="password" name="password"
                                           class="{{ $errors->has('password') ? 'invalid validate' : 'validate' }}" required>
                                    <label for="password"
                                           {!! $errors->has('password') ? 'data-error="'.$errors->first('password').'"'
                                        : '' !!}>
                                        Password</label>
                                </div>
                            </div>
                            {{--
                            <div class="row">
                                <p>
                                <div id="g-recaptcha" class="g-recaptcha"
                                     data-sitekey="6LeMiz4UAAAAAEkyHbGH6koPZvUNpXXNJ-D34Hd2"></div>
                                @if(session()->has('recaptcha_error'))
                                <label for="g-recaptcha" style="color: red">
                                    {{ session('recaptcha_error') }}
                                </label>
                                @endif
                                </p>
                            </div>
                            --}}
                            <div class="row">
                                <div class="input-field">
                                    <button type="submit" href="index.html"
                                            class="btn waves-effect waves-light orange lighten-2 col s12">Se connecter
                                    </button>
                                </div>
                            </div>
                            <div class="row">
                                <div class="input-field">
                                    <p class="right-align"><a href="{{ url('/password/reset') }}">Mot
                                            de passe oublié ?</a></p>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="card-stacked blue-grey darken-1 hide-on-med-and-down">
                    <div class="card-content white-text" style="margin-top: 20%">
                        <div class="input-field col center">
                            <img src="img/logo.png" alt=""
                                 class="circle responsive-img valign profile-image-login"/>
                            <p class="center" style="color: #fafafa; margin-top: 10px">PORT AUTONOME DE COTONOU</p>
                            <p class="center">_____</p>
                            <p class="center" style="color: #bdbdbd; margin-top: 10px">APPLICATION DE GESTION DES TITRES
                                D'ACCES TEMPORAIRES</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @endsection
