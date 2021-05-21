@extends('layouts.app')
@section('content')
    <nav class="green lighten-2 menu">
        <div class="nav-wrapper">
            <div class="col s12">
                <a href="{{ route('home') }}" class="breadcrumb"><i class="material-icons">home</i></a>
                <a href="{{ url('configurations') }}" class="breadcrumb">Configurations</a>
                <a href="{{ route('zone.index') }}" class="breadcrumb">Zones</a>
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

    <div class="container" style="margin-top: 30px">
        <div class="card">
            <div class="card-image">
                <a href="#modal_zone" class="btn-floating halfway-fab btn-large waves-effect waves-light green modal-trigger">
                    <i class="material-icons">add</i></a>
            </div>
            <div class="card-content">
                <table id="search_table">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>Libelle</th>
                        <th style="max-width: 10px">#</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($zones as $zone)
                        <tr>
                            <td style="width: 10%">{{ isset($i) ? ++$i : $i=1 }}</td>
                            <td style="width: 85%">{{ $zone->libelle }}</td>
                            <td style="max-width: 10px"><a href="#!" class="waves-effect dropdown-button grey-text text-darken-1"
                                                           data-activates="dropdown_menu"><i class="material-icons">more_vert</i></a>
                            </td>

                            <ul id='dropdown_menu' class='dropdown-content'>
                                {{--<li><a href="{{ route('zone.show', [$zone->id]) }}" class="waves-effect waves-light grey-text text-darken-2">Voir</a></li>--}}
                                <li><a href="{{ route('zone.edit', [$zone->id]) }}"
                                       class="waves-effect waves-light grey-text text-darken-2">Modifier</a></li>
                                {!! Form::open(['method' => 'DELETE', 'route' => ['zone.destroy', $zone->id]]) !!}
                                <li><a href="#!" onclick="$('#del_zone{{ $zone->id }}').click();"
                                       class="waves-effect waves-light grey-text text-darken-2">Supprimer</a></li>
                                {!! Form::submit('Supprimer', ['id'=>'del_zone'.$zone->id,'class' => 'btn btn-danger btn-block hide', 'onclick' => 'return confirm(\'Vraiment supprimer cette zone ?\')']) !!}
                                {!! Form::close() !!}
                            </ul>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="row">
        <div id="modal_zone" class="modal" style="width:30%">
            {!! Form::open(['url'=>'zone','method'=>'post']) !!}
            <div class="modal-content white">
                <h5 class="modal-title" style="margin-left: 50px">Nouvelle Zone</h5><br>
                <div class="row">
                    <div class="input-field col s12">
                        <i class="material-icons prefix">mode_edit</i>
                        <?php
                        $class = $errors->has('libelle') ? 'invalid validate' : 'validate';
                        echo Form::text('libelle', null, ['class' => "$class", 'id' => 'libelle']);
                        ?>
                        <label {!! $errors->has('libelle') ? 'data-error="'.$errors->first('libelle').'"' : '' !!}>
                            Libellé de la zone</label>
                    </div>
                </div>
            </div>
            <div class="modal-footer grey lighten-3">
                <a class="btn modal-action modal-close waves-effect white-text grey">Retour</a>
                {!! Form::submit('Enregistrer',['class' => 'btn green lighten-1']) !!}
            </div>
            {!! Form::close() !!}
        </div>
        @if($errors->has('libelle'))
            <script type="text/javascript">
                window.onload = function () {
                    $('#modal_zone').modal('open');
                };
            </script>
        @endif
    </div>
@endsection