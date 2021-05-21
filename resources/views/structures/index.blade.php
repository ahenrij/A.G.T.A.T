@extends('layouts.app')

@section('content')

    <nav class="orange lighten-2 menu">
        <div class="nav-wrapper">
            <div class="col s12">
                <a href="{{ route('home') }}" class="breadcrumb"><i class="material-icons">home</i></a>
                <a href="{{ url('configurations') }}" class="breadcrumb">Configurations</a>
                <a href="{{ route('structure.index') }}" class="breadcrumb">Structures</a>
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
                    <a href="#modal_structure"
                       class="btn-floating halfway-fab btn-large waves-effect waves-light orange modal-trigger">
                        <i class="material-icons">add</i></a>
                </div>
                <div class="card-content">
                    <table id="search_table">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th style="width: 15%">Raison Sociale</th>
                            <th style="width: 15%">Contact</th>
                            <th style="width: 70%">Adresse</th>
                            <th >#</th>
                            {{--<th>#</th>--}}
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($structures as $structure)
                            <tr>
                                <td>{!! isset($i) ? ++$i : $i=1 !!}</td>
                                <td>{!!  $structure->raison_sociale !!}</td>
                                <td>{{  $structure->contact }}</td>
                                <td style="width: 60%" class="">{{ $structure->adresse }}</td>
                                <td style="max-width: 10px">
                                    <a href="#!" class="waves-effect dropdown-button grey-text text-darken-1" data-activates="dropdown_menu"><i class="material-icons">more_vert</i></a>
                                </td>

                                <ul id='dropdown_menu' class='dropdown-content'>

                                    <li><a href="{{ route('structure.edit', [$structure->id]) }}"
                                           class="waves-effect waves-light grey-text text-darken-2">Modifier</a>
                                    </li>
                                    {!! Form::open(['method' => 'DELETE', 'route' => ['structure.destroy', $structure->id]]) !!}
                                    <li><a href="#!" onclick="$('#del_structure{{ $structure->id }}').click();"
                                           class="waves-effect waves-light grey-text text-darken-2">Supprimer</a>
                                    </li>
                                    {!! Form::submit('Supprimer', ['id'=>'del_structure'.$structure->id,'class' => 'btn btn-danger btn-block hide', 'onclick' => 'return confirm(\'Vraiment supprimer cette structure ?\')']) !!}
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
    <div class="row">

        <div id="modal_structure" class="modal" style="width:35%">
            {!! Form::open(['url'=>'structure','method'=>'post']) !!}
            <div class="modal-content">
                <h5 class="center">Nouvelle structure</h5><br>
                <div class="row center">
                    <div class="input-field col m12 s12">
                        <i class="material-icons prefix">mode_edit</i>
                        <?php
                        $class = $errors->has('raison_sociale') ? 'invalid validate' : 'validate';
                        echo Form::text('raison_sociale',null,['class' => "$class"]);
                        ?>
                        <label for="raison_sociale"
                                {!! $errors->has('raison_sociale') ? 'data-error="'.$errors->first('raison_sociale').'"' : '' !!}>
                            Raison sociale</label>
                    </div>
                    <div class="input-field col m12 s12">
                        <i class="material-icons prefix">phone</i>
                        <?php
                        $class = $errors->has('contact') ? 'invalid validate' : 'validate';
                        echo Form::text('contact',null,['class' => "$class"]);
                        ?>
                        <label for="contact"
                                {!! $errors->has('contact') ? 'data-error="'.$errors->first('contact').'"' : '' !!}>
                            Contact</label>
                    </div>
                    <div class="input-field col m12 s12">
                        <i class="material-icons prefix">domain</i>
                        <?php
                        $class = $errors->has('adresse') ? 'invalid validate' : 'validate';
                        echo Form::text('adresse',null,['class' => "$class"]);
                        ?>
                        <label for="adresse"
                                {!! $errors->has('adresse') ? 'data-error="'.$errors->first('adresse').'"' : '' !!}>
                            Adresse</label>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <a class="btn modal-action modal-close waves-effect btn-flat white-text grey">Retour</a>
                {!! Form::submit('Enregistrer',['class' => 'btn green lighten-1']) !!}
            </div>
            {!! Form::close() !!}
        </div>
        @if($errors->has('raison_sociale')||$errors->has('adresse')||$errors->has('contact'))
            <script type="text/javascript">
                window.onload = function () {
                    $('#structure').modal('open');
                };
            </script>
        @endif
    </div>
@stop