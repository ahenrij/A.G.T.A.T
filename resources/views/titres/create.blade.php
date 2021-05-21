@extends('layouts.app')

@section('content')

    <nav class="grey lighten-1 menu">
        <div class="nav-wrapper">
            <div class="col s12">
                <a href="{{ route('home') }}" class="breadcrumb"><i class="material-icons">home</i></a>
                <a href="{{ route('titre.index') }}" class="breadcrumb">Titres d'Accès</a>
                <a href="#!" class="breadcrumb">Nouveau</a>
            </div>
        </div>
    </nav>

    <div class="row">
        <div class="col s12">
            <meta name="_token" content="{{ csrf_token() }}"/>
            {!! Form::open(['route' => 'titre.store', 'class' => 'col s12', 'id' => 'titre_create' ]) !!}
            <div class="card">
                <div class="card-content">
                    <div class="row">
                        <h5 class="float-right"
                            style="margin-left: 16px;margin-bottom: 30px; font-family: 'Lato Medium', Courier, monospace">N°
                            <span id="numero_titre">{{ substr("0000000", 0, 7 - strlen($numero)) . $numero  }}</span>
                        </h5>
                        <div class="row">
                            <div class="input-field col m5 s10">
                                <i class="material-icons prefix">description</i>
                                {{ Form::select('type_titre_id', $type_titres, null, ['class' => 'validate', 'id' =>'type_titre_id', 'action' => url('/type_titre_infos')]) }}
                                {{ Form::label('type_titre_id', 'Type de titres d\'accès') }}
                            </div>
                            <div class="input-field col m1 s2">
                                <a class="btn-floating halfway-fab btn-medium waves-effect waves-light green modal-trigger"
                                   href="#modal_typetitre"><i class="material-icons">add</i></a>
                            </div>
                            <div class="input-field col m5 s10">
                                <i class="material-icons prefix">location_on</i>
                                {{ Form::select('zone_id', $zones, null, ['class' => 'validate', 'id' => 'zone_id']) }}
                                {{ Form::label('zone_id', 'Zone d\'Activité') }}
                            </div>
                            <div class="input-field col m1 s2">
                                <a class="btn-floating halfway-fab btn-medium waves-effect waves-light green modal-trigger"
                                   href="#modal_zone"><i class="material-icons">add</i></a>
                            </div>
                        </div>
                        <div class="row">
                            <div id="div_beneficiaire" class="input-field col m5 s10">
                                <i class="material-icons prefix">person_outline</i>
                                {{ Form::text('beneficiaire', null, ['class' => 'validate', 'id' => 'beneficiaire', 'list' => 'list_beneficiaires', 'action' => url('/user_infos')]) }}
                                {{ Form::label('beneficiaire', 'Bénéficiaire', ['id' => 'label_beneficiaire']) }}
                                <datalist id="list_beneficiaires">
                                    @foreach($users as $id => $user)
                                        <option id="{{ $id }}" value="{{ $user }}"/>
                                    @endforeach
                                </datalist>
                            </div>
                            <div class="input-field col m1 s2">
                                <a class="btn-floating halfway-fab btn-medium waves-effect waves-light green modal-trigger"
                                   href="#modal_beneficiaire"><i class="material-icons">add</i></a>
                            </div>
                            <div class="input-field col m5 s12">
                                <i class="material-icons prefix">contact_mail</i>
                                {{ Form::select('piece', $justifs, null, ['class' => 'validate', 'id' => 'piece']) }}
                                {{ Form::label('piece', 'Pièce justificative') }}
                            </div>
                        </div>
                        <div class="row">
                            <div class="input-field col m5 s10">
                                <i class="material-icons prefix">business</i>
                                {{ Form::text('structure', null, ['class' => 'validate', 'id' => 'structure', 'disabled' => 'true']) }}
                                {{ Form::label('structure', 'Structure', ['id' => 'label_structure']) }}
                            </div>
                            <div class="input-field col m1 s2">
                                <a class="btn-floating halfway-fab btn-medium waves-effect waves-light green modal-trigger"
                                   href="#modal_structure"><i class="material-icons">add</i></a>
                            </div>
                            <div id="#div_fonction" class="input-field col m5 s12">
                                <i class="material-icons prefix">work_outline</i>
                                {{ Form::text('fonction', null, ['class' => 'validate', 'id' => 'fonction', 'disabled' => 'true']) }}
                                {{ Form::label('fonction', 'Fonction', ['id' => 'label_fonction']) }}
                            </div>
                        </div>
                        <div class="row">
                            <div class="input-field col m5 s12">
                                <i class="material-icons prefix">phone</i>
                                {{ Form::text('telephone', null, ['class' => 'validate', 'id' => 'telephone', 'disabled' => 'true']) }}
                                {{ Form::label('telephone', 'Téléphone', ['id' => 'label_telephone']) }}
                            </div>
                            <div id="div_matricule" class="input-field col m5  offset-m1 s10 hide">
                                <i class="material-icons prefix">label_outline</i>
                                {{ Form::text('matricule', null, ['class' => 'validate', 'id' => 'matricule', 'list' => 'list_matricules', 'action' => url('/vehicule_infos')]) }}
                                {{ Form::label('matricule', 'Matricule', ['id' => 'label_matricule']) }}
                                <datalist id="list_matricules">
                                    @foreach($vehicules as $id => $matricule)
                                        <option id="{{ $id }}" value="{{ $matricule }}"/>
                                    @endforeach
                                </datalist>
                            </div>
                            <div class="input-field col m1 s2 hide" id="btn_add_vehicule">
                                <a class="btn-floating halfway-fab btn-medium waves-effect waves-light green modal-trigger"
                                   href="#modal_vehicule"><i class="material-icons">add</i></a>
                            </div>
                        </div>
                        <div class="row">
                            <div class="input-field col m4 s9">
                                <i class="material-icons prefix">date_range</i>
                                {{ Form::text('date_delivrance', caisseIsClosed() ?  date('d/m/Y', strtotime('+24 hours')) : date('d/m/Y'), ['class' => "datepicker", 'id' => 'date_delivrance']) }}
                                {{ Form::label('date_delivrance', 'Date de délivrance', ['id' => 'label_date_delivrance']) }}
                            </div>
                            <div class="input-field col m1 s3">
                                {{ Form::text('heure_delivrance', null, ['class' => "text-center", 'placeholder' => '00:00:00', 'id' => 'heure_delivrance', 'disabled' => 'true']) }}
                            </div>
                            <div class="input-field col m2 s12">
                                <i class="material-icons prefix">timer</i>
                                {{ Form::number('duree', 24, ['class' => 'validate', 'step' => '24', 'min' => '24', 'id' => 'duree']) }}
                                {{ Form::label('duree', 'Durée (heures)', ['id' => 'label_duree']) }}
                            </div>
                            <div class="input-field col m4 s12">
                                <i class="material-icons prefix">date_range</i>
                                {{ Form::text('date_validite', caisseIsClosed() ? date('d/m/Y', strtotime('+48 hours')) : date('d/m/Y', strtotime('+24 hours')), ['class' => 'validate', 'disabled' => 'true', 'id' => 'date_validite']) }}
                                {{ Form::label('date_validite', 'Date de validité') }}
                            </div>
                            <div class="input-field col m1 s3">
                                {{ Form::text('heure_validite', null, ['class' => 'text-center', 'placeholder' => '00:00:00', 'disabled' => 'true', 'id' => 'heure_validite']) }}
                            </div>
                        </div>

                        <div class="row">
                            <div class="input-field col m5 s12">
                                <i class="material-icons prefix">attach_money</i>
                                {{ Form::number('cout_ht', $titres_prix->first(), ['class' => 'validate', 'id' => 'cout_ht', 'disabled' => 'true']) }}
                                {{ Form::label('cout_ht', 'Coût badge HT') }}
                            </div>
                            <div class="input-field col m1 s2">
                                <a class="btn-floating halfway-fab btn-medium waves-effect waves-light green modal-trigger"
                                   href="#calculatrice"><i class="material-icons">dialpad</i></a>
                            </div>
                            <div class="input-field col m5 s12">
                                <i class="material-icons prefix">attach_money</i>
                                {{ Form::number('cout_ttc', $titres_prix->first() * 1.18, ['class' => 'validate', 'id' => 'cout_ttc', 'disabled' => 'true']) }}
                                {{ Form::label('cout_ttc', 'Coût badge TTC') }}
                            </div>
                        </div>

                        <div id="caisse_closed" style="margin-left: 15px" value="{{ caisseIsClosed() ? 1:0 }}" class="red-text">
                            @if(caisseIsClosed())
                            <i class="material-icons left">info</i>La caisse est fermée ! Tous les titres qui seront délivrés aujourd'hui ne pourront être utilisés qu'à partir de demain.
                            @endif
                        </div>

                    </div>
                </div>
                <div class="card-action right-align grey lighten-5">
                    {!! Form::button('Enregistrer', ['class' => 'btn green lighten-1', 'id' => 'submit_save_titre', 'link' => route('titre.store'), 'show_link' => route('titre.show', 0)]) !!}
                </div>
            </div>
            {!! Form::close() !!}

        </div>
    </div>


    {{-- MODALS --}}


    {{--Calculatrice--}}
    <div id="calculatrice" class="modal" style="background-color: #fff;">

        <div class="modal-content container primary-text-color unselectable">
            {{--<div class="center" id="clc" style="cursor: pointer;">CLC</div>--}}

            <div class="row" style="background-color: #eee">
                <div class="calculator-buttons flow-text">

                    <div class="col l12 m12 s12 display default-primary-color text-primary-color right-align"
                         id="display" style="background-color: #e0e0e0; color: #424242;"></div>
                    <div class="waves-effect col l3 m3 s3 button btnClick center default-primary-color"><span
                                id="divide">÷</span></div>
                    <div class="waves-effect col l3 m3 s3 button btnClick center default-primary-color"><span
                                id="multiple">*</span></div>
                    <div class="waves-effect col l3 m3 s3 button btnClick center ac-ce accent-color"><span
                                id="clc">AC</span></div>
                    <div class="waves-effect col l3 m3 s3 button btnClick center ac-ce accent-color"><span
                                id="ce">CE</span></div>
                    <div class="waves-effect col l3 m3 s3 button btnClick center default-primary-color"><span
                                id="seven">7</span></div>
                    <div class="waves-effect col l3 m3 s3 button btnClick center default-primary-color"><span
                                id="eight">8</span></div>
                    <div class="waves-effect col l3 m3 s3 button btnClick center default-primary-color"><span
                                id="nine">9</span>
                    </div>
                    <div class="waves-effect col l3 m3 s3 button btnClick center default-primary-color"><span
                                id="minus">-</span></div>
                    <div class="waves-effect col l3 m3 s3 button btnClick center default-primary-color"><span
                                id="four">4</span>
                    </div>
                    <div class="waves-effect col l3 m3 s3 button btnClick center default-primary-color"><span
                                id="five">5</span>
                    </div>
                    <div class="waves-effect col l3 m3 s3 button btnClick center default-primary-color"><span
                                id="six">6</span></div>
                    <div class="waves-effect col l3 m3 s3 button btnClick center default-primary-color"><span
                                id="plus">+</span>
                    </div>
                    <div class="small-container">
                        <div class="bottom-container float-left">
                            <div class="waves-effect button btnClick center default-primary-color"><span
                                        id="one">1</span></div>
                            <div class="waves-effect button btnClick center default-primary-color"><span
                                        id="two">2</span></div>
                            <div class="waves-effect button btnClick center default-primary-color"><span
                                        id="three">3</span></div>
                            <div class="waves-effect button btnClick center default-primary-color zero-sign"><span
                                        id="zero">0</span></div>
                            <div class="waves-effect button btnClick center default-primary-color"><span
                                        id="dot">.</span></div>
                        </div>
                        <div class="waves-effect button btnClick center float-right dark-primary-color" id="equal"
                             style="height: 150px"><span
                                    id="equal-sign" style="height: 150px" class="center">=</span></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <a href="#!" class="modal-action modal-close btn red darken-2 waves-effect waves-red white-text"
               style="font-size: 15px">Fermer</a>
        </div>
    </div>


    {{--Type de Titre--}}
    <div id="modal_typetitre" class="modal" style="width:35%">
        {!! Form::open(['route'=>'typetitre.store']) !!}
        <div class="modal-content white">
            <h5 class="modal-title" style="margin-left: 50px">Nouveau type de titre</h5><br>
            <div class="row">
                <div class="input-field col s4">
                    <i class="material-icons prefix">label_outline</i>
                    {{ Form::select('code', array('BT' => 'BT', 'MT' => 'MT'), null, ['class' => 'validate', 'id' => 'code_type', 'link' => route('verifyTypeTitreExist')]) }}
                    {{ Form::label('code_type', 'Code') }}
                </div>
                <div class="input-field col s8">
                    {{ Form::text('libelle', null, ['class' => 'validate', 'id' => 'libelle_type_titre']) }}
                    {{ Form::label('libelle_type_titre', 'Libellé', ['id' => 'label_libelle_type_titre']) }}
                </div>
            </div>
            <div class="row">
                <div class="input-field col s12">
                    <i class="material-icons prefix">edit</i>
                    {{ Form::number('duree', null, ['class' => 'validate', 'step' => '24', 'id' => 'duree_add_tt']) }}
                    {{ Form::label('duree_add_tt', 'Durée : en heures', ['id' => 'label_duree_add_tt']) }}
                </div>
            </div>
            <div class="row">
                <div class="input-field col s12">
                    <i class="material-icons prefix">euro_symbol</i>
                    {{ Form::number('prix', null, ['class' => 'validate', 'id' => 'prix_add_tt']) }}
                    {{ Form::label('prix_add_tt', 'Prix', ['id' => 'label_prix_add_tt']) }}
                </div>
            </div>
        </div>
        <div class="modal-footer grey lighten-3">
            <a class="btn modal-action modal-close waves-effect white-text grey">Retour</a>
            {!! Form::button('Enregistrer',['class' => 'btn green lighten-1', 'id' => 'submit_add_type_titre', 'link' => route('saveTypeTitreByAjax')]) !!}
        </div>
        {!! Form::close() !!}
    </div>



    {{-- Zone --}}
    <div id="modal_zone" class="modal" style="width:30%">
        {!! Form::open(['url'=>'zone','method'=>'post']) !!}
        <div class="modal-content white">
            <h5 class="modal-title" style="margin-left: 50px">Nouvelle Zone</h5><br>
            <div class="row">
                <div class="input-field col s12">
                    <i class="material-icons prefix">mode_edit</i>
                    {{ Form::text('libelle', null, ['class' => 'validate', 'id' => 'libelle_zone']) }}
                    {{ Form::label('libelle_zone', 'Libellé de la zone', ['id' => 'label_lib_zone']) }}
                </div>
            </div>
        </div>
        <div class="modal-footer grey lighten-3">
            <a class="btn modal-action modal-close waves-effect white-text grey">Retour</a>
            {!! Form::button('Enregistrer',['class' => 'btn green lighten-1', 'id'=> 'submit_add_zone', 'link'=> route('saveZoneByAjax')]) !!}
        </div>
        {!! Form::close() !!}
    </div>


    {{-- Structure --}}
    <div id="modal_structure" class="modal" style="width:35%">
        {!! Form::open(['url'=>'structure','method'=>'post']) !!}
        <div class="modal-content white">
            <h5 class="modal-title" style="margin-left: 50px">Nouvelle structure</h5><br>
            <div class="row center">
                <div class="input-field col m12 s12">
                    <i class="material-icons prefix">label_outline</i>
                    {{ Form::text('raison_sociale', null, ['class' => 'validate', 'id' => 'raison_sociale']) }}
                    {{ Form::label('raison_sociale', 'Raison sociale', ['id' => 'label_raison_sociale']) }}
                </div>
                <div class="input-field col m12 s12">
                    <i class="material-icons prefix">phone</i>
                    {{ Form::text('contact', null, ['class' => 'validate', 'id' => 'contact_structure']) }}
                    {{ Form::label('contact_structure', 'Contact', ['id' => 'label_contact_structure']) }}
                </div>
                <div class="input-field col m12 s12">
                    <i class="material-icons prefix">domain</i>
                    {{ Form::text('adresse', null, ['class' => 'validate', 'id' => 'adresse_structure']) }}
                    {{ Form::label('adresse_structure', 'Adresse', ['id' => 'label_adresse_structure']) }}
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <a class="btn modal-action modal-close waves-effect btn-flat white-text grey">Retour</a>
            {!! Form::button('Enregistrer',['class' => 'btn green lighten-1', 'id'=> 'submit_add_structure', 'link'=> route('saveStructureByAjax')]) !!}
        </div>
        {!! Form::close() !!}
    </div>




    {{-- Véhicule --}}
    <div id="modal_vehicule" class="modal">
        {!! Form::open(['url'=>'vehicule','method'=>'post']) !!}
        <div class="modal-content white">
            <h4 class="modal-title" style="margin-left: 50px">Véhicule</h4><br>
            <div class="row">
                <div class="input-field col m6 s12">
                    <i class="material-icons prefix">mode_edit</i>
                    {{ Form::text('immatriculation', null, ['class' => 'validate', 'id' => 'immatriculation']) }}
                    {{ Form::label('immatriculation', 'Immatriculation', ['id' => 'label_immatriculation']) }}
                </div>
                <div class="input-field col m6 s12">
                    <i class="material-icons prefix">label_outline</i>
                    {{ Form::text('marque', null, ['class' => 'validate', 'id' => 'marque']) }}
                    {{ Form::label('marque', 'Marque', ['id' => 'label_marque']) }}
                </div>
            </div>
            <div class="row">
                <div class="input-field col m6 s12">
                    <i class="material-icons prefix">directions_car</i>
                    {{ Form::select('type_vehicule_id', $type_vehicules, null, ['class' => 'validate', 'id' => 'vehicule_type_id']) }}
                    {{ Form::label('vehicule_type_id', 'Type de véhicule', ['id' => 'label_type_vehicule']) }}
                </div>
                <div class="input-field col m6 s12">
                    <i class="material-icons prefix">perm_identity</i>
                    {{ Form::select('user_id', $users, null, ['class' => 'validate', 'id' => 'vehicule_user_id']) }}
                    {{ Form::label('vehicule_user_id', 'Responsable') }}
                </div>
            </div>
        </div>
        <div class="modal-footer grey lighten-3">
            <a class="btn modal-action modal-close waves-effect btn-flat white-text grey">Retour</a>
            {!! Form::button('Enregistrer',['class' => 'btn green lighten-1', 'id'=> 'submit_add_vehicule', 'link'=> route('saveVehiculeByAjax')]) !!}
        </div>
        {!! Form::close() !!}
    </div>



    {{-- Bénéficiaire --}}
    <div id="modal_beneficiaire" class="modal">
        {!! Form::open(['route' => 'user.store', 'class' => 'col s12']) !!}
        <div class="modal-content white">
            <h5 class="modal-title" style="margin-left: 50px">Nouveau Bénéficiaire</h5><br>
            <div class="row">
                <div class="row">
                    <div class="input-field col m6 s12" style="margin-bottom: 0px">
                        <i class="material-icons prefix">person_outline</i>
                        {{ Form::text('nom', null, ['class' => 'validate', 'id' => 'nom_beneficiaire']) }}
                        {{ Form::label('nom_beneficiaire', 'Nom', ['id' => 'label_nom_beneficiaire']) }}
                    </div>

                    <div class="input-field col m6 s12">
                        <i class="material-icons prefix"></i>
                        {{ Form::text('prenom', null, ['class' => 'validate', 'id' => 'prenom_beneficiaire']) }}
                        {{ Form::label('prenom_beneficiaire', 'Prénoms', ['id' => 'label_prenom_beneficiaire']) }}
                    </div>
                </div>

                <div class="row">
                    <div class="input-field col m6 s12">
                        <i class="material-icons prefix">work_outline</i>
                        {{ Form::text('fonction', null, ['class' => 'validate', 'id' => 'fonction_beneficiaire']) }}
                        {{ Form::label('fonction_beneficiaire', 'Fonction', ['id' => 'label_fonction_beneficiaire']) }}
                    </div>
                    <div class="input-field col m6 s12">
                        <i class="material-icons prefix">business</i>
                        {{ Form::select('structure_id', $structures, null, ['class' => 'validate', 'id' =>'list_structures_id']) }}
                        {{ Form::label('list_structures_id', 'Structure') }}
                    </div>
                </div>
                <div class="row">
                    <div class="input-field col m6 s12">
                        <i class="material-icons prefix">phone</i>
                        {{ Form::text('telephone', null, ['class' => 'validate', 'id' => 'telephone_beneficiaire', 'link' => route('checkPhoneNumberExist')]) }}
                        {{ Form::label('telephone_beneficiaire', 'Téléphone', ['id' => 'label_telephone_beneficiaire']) }}
                    </div>
                    <div class="input-field col m6 s12">
                        <i class="material-icons prefix">location_outline</i>
                        {{ Form::text('adresse', null, ['class' => 'validate', 'id' => 'adresse_beneficiaire']) }}
                        {{ Form::label('adresse_beneficiaire', 'Adresse', ['id' => 'label_adresse_beneficiaire']) }}
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer grey lighten-3">
            <a class="btn modal-action modal-close waves-effect white-text grey">Retour</a>
            {!! Form::button('Enregistrer',['class' => 'btn green lighten-1', 'id'=> 'submit_add_beneficiaire', 'link'=> route('saveBeneficiaireByAjax')]) !!}
        </div>
        {!! Form::close() !!}
    </div>

@endsection