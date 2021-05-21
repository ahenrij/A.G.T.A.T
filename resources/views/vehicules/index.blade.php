@extends('layouts.app')

@section('content')
    <nav class="purple lighten-2 menu">
        <div class="nav-wrapper">
            <div class="col s12">
                <a href="{{ route('home') }}" class="breadcrumb"><i class="material-icons">home</i></a>
                <a href="{{ url('configurations') }}" class="breadcrumb">Configurations</a>
                <a href="{{ route('vehicule.index') }}" class="breadcrumb">Véhicules</a>
            </div>
        </div>
    </nav>

    @if(session()->has('ok'))
        <script type="text/javascript">
            var message = "{{ session('ok') }}";
            window.onload = function () {
                Materialize.toast(message, 4000);
            };
        </script>
    @endif

    <div class="row">
        <div class="col s12 m12">
            <div class="card">
                <div class="card-image">
                    <a href="#modal_vehicule" class="btn-floating halfway-fab btn-large waves-effect waves-light purple modal-trigger">
                        <i class="material-icons">add</i></a>
                </div>
                <div class="card-content">
                    <table id="search_table">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Immatriculation</th>
                            <th>Marque</th>
                            <th>Type</th>
                            <th>Responsable</th>
                            <th>#</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($vehicules as $vehicule)
                            <tr>
                                <td>{!! isset($i) ? ++$i : $i=1 !!}</td>
                                <td>{{ $vehicule->immatriculation }}</td>
                                <td>{{ $vehicule->marque }}</td>
                                <td>{{ $vehicule->typeVehicule->libelle }}</td>
                                <td>{{ $vehicule->user->prenom.' '.$vehicule->user->nom }}</td>

                                <td style="max-width: 10px"><a href="#!" class="waves-effect dropdown-button grey-text text-darken-1"
                                                               data-activates="dropdown_menu"><i class="material-icons">more_vert</i></a>
                                </td>

                                <ul id='dropdown_menu' class='dropdown-content'>
                                    <li><a href="{{ route('vehicule.show', [$vehicule->id]) }}" class="waves-effect waves-light grey-text text-darken-2">Voir</a></li>
                                    <li><a href="{{ route('vehicule.edit', [$vehicule->id]) }}"
                                           class="waves-effect waves-light grey-text text-darken-2">Modifier</a></li>
                                    {!! Form::open(['method' => 'DELETE', 'route' => ['vehicule.destroy', $vehicule->id]]) !!}
                                    <li><a href="#!" onclick="$('#del_veh{{ $vehicule->id }}').click();"
                                           class="waves-effect waves-light grey-text text-darken-2">Supprimer</a></li>
                                    {!! Form::submit('Supprimer', ['id'=>'del_veh'.$vehicule->id,'class' => 'btn btn-danger btn-block hide', 'onclick' => 'return confirm(\'Vraiment supprimer ce véhicule ?\')']) !!}
                                    {!! Form::close() !!}
                                </ul>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    {{--Importation des liste de type véhicule et des responsables--}}



    {{--Formulaire d'ajout d'un véhicule--}}

    <div class="row">
        <div id="modal_vehicule" class="modal">
            {!! Form::open(['url'=>'vehicule','method'=>'post']) !!}
            <div class="modal-content white">
                <h4 class="modal-title" style="margin-left: 50px">Véhicule</h4><br>
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
            <div class="modal-footer grey lighten-3">
                <a class="btn modal-action modal-close waves-effect btn-flat white-text grey">Annuler</a>
                {!! Form::submit('Enregistrer',['class' => 'btn green lighten-1']) !!}
            </div>
            {!! Form::close() !!}
        </div>
        @if($errors->has('immatriculation') || $errors->has('marque'))
            <script type="text/javascript">
                window.onload = function () {
                    $('#modal_vehicule').modal('open');
                };
            </script>
        @endif
    </div>
@endsection