@extends('layouts.app')

@section('content')

    <nav class="grey lighten-1 menu">
        <div class="nav-wrapper">
            <div class="col s12">
                <a href="{{ route('home') }}" class="breadcrumb"><i class="material-icons">home</i></a>
                <a href="#!" class="breadcrumb">Demandes</a>
                <a href="#!" class="breadcrumb">Nouvelle demande</a>
            </div>
        </div>
    </nav>

    @if(session()->has('er'))
        <script type="text/javascript">
            var message = "{{ session('er') }}";
            window.onload = function () {
                Materialize.toast(message, 4000);
            };
        </script>
    @endif
    <div class="row">
        <div class="col s12">
            {!! Form::open(['route' => 'demande.store', 'class' => 'col s12']) !!}
            <div class="card">
                <div class="card-content">
                    <br>
                    <div class="row">
                        <div class="row">
                            <div class="input-field col m5 s10">
                                <i class="material-icons prefix">description</i>
                                {{ Form::select('type_titre_id', $type_titres, null, ['class' => 'validate', 'id' =>'type_titre_id', 'action' => url('/type_titre_infos')]) }}
                                {{ Form::label('type_titre_id', 'Type de titres d\'accès') }}
                            </div>
                            <div class="input-field col m5 s10 offset-m1">
                                <i class="material-icons prefix">location_on</i>
                                {{ Form::select('zone_id', $zones, null, ['class' => 'validate', 'id' => 'zone_id']) }}
                                {{ Form::label('zone_id', 'Zone d\'Activité') }}
                            </div>
                        </div>
                        <div class="row">
                            <div id="div_beneficiaire" class="input-field col m5 s10">
                                <i class="material-icons prefix">person_outline</i>
                                {{ Form::text('beneficiaire', Auth::user()->nom.' '.Auth::user()->prenom, ['class' => 'validate', 'disabled' => 'true']) }}
                                {{ Form::label('beneficiaire', 'Bénéficiaire') }}
                            </div>
                            <div class="input-field col m5 s10 offset-m1">
                                <i class="material-icons prefix">contact_mail</i>
                                {{ Form::select('piece', $justifs, null, ['class' => 'validate']) }}
                                {{ Form::label('piece', 'Pièce justificative') }}
                            </div>
                        </div>
                        <div class="row">
                            <div class="input-field col m5 s10">
                                <i class="material-icons prefix">date_range</i>
                                {{ Form::text('date_demande', date('d/m/Y  à  H:i:s'), ['disabled', 'true']) }}
                                {{ Form::label('date_demande', 'Date de demande') }}
                            </div>
                            <div class="input-field col m5 s10 offset-m1">
                                <i class="material-icons prefix">timer</i>
                                {{ Form::number('duree', 24, ['class' => 'validate', 'step' => '24', 'min' => '24', 'id' => 'duree']) }}
                                {{ Form::label('duree', 'Durée (heures)', ['id' => 'label_duree']) }}
                            </div>
                        </div>
                        <div class="row">
                            <div class="input-field col m5 s12">
                                <i class="material-icons prefix">attach_money</i>
                                {{ Form::number('cout_ht', 0, ['class' => 'validate', 'id' => 'cout_ht', 'disabled' => 'true']) }}
                                {{ Form::label('cout_ht', 'Coût badge HT') }}
                            </div>

                            <div class="input-field col col m5 s10 offset-m1">
                                <i class="material-icons prefix">attach_money</i>
                                {{ Form::number('cout_ttc', 0, ['class' => 'validate', 'id' => 'cout_ttc', 'disabled' => 'true']) }}
                                {{ Form::label('cout_ttc', 'Coût badge TTC') }}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-action right-align grey lighten-5">
                    {!! Form::submit('Enregistrer', ['class' => 'btn green lighten-1']) !!}
                </div>
            </div>
            {!! Form::close() !!}

        </div>
    </div>

@endsection