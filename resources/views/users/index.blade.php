@extends('layouts.app')

@section('content')

    <nav class="grey lighten-1 menu">
        <div class="nav-wrapper">
            <div class="col s12">
                <a href="{{ route('user.index') }}" class="breadcrumb">Utilisateurs</a>
                <a href="#!" class="breadcrumb">Liste des utilisateurs</a>
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
                    <a href="{{ route('user.create') }}"
                       class="btn-floating halfway-fab btn-large waves-effect waves-light green"><i
                                class="material-icons">person_add</i></a>
                </div>
                <div class="card-content">
                    <table id="search_table">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Nom et Prénoms</th>
                            <th>Structure</th>
                            <th>Fonction</th>
                            <th>Téléphone</th>
                            <th>#</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($users as $user)
                            @if($user->nom != AUCUN_DISTRIBUTEUR)
                            <tr>
                                <td>{!! isset($i) ? ++$i : $i=1 !!}</td>
                                <td>{!! $user->nom.' '.$user->prenom !!}</td>
                                <td>{!! $user->structure->raison_sociale !!}</td>
                                <td>{!! $user->fonction !!}</td>
                                <td>{!! $user->telephone !!}</td>
                                <td><a href="#!" class="waves-effect dropdown-button grey-text text-darken-1" data-activates="dropdown_menu"><i class="material-icons">more_vert</i></a></td>

                                <ul id='dropdown_menu' class='dropdown-content'>
                                    <li><a href="{{ route('user.show', [$user->id]) }}" class="waves-effect waves-light grey-text text-darken-2">Voir</a></li>
                                    <li><a href="{{ route('user.edit', [$user->id]) }}" class="waves-effect waves-light grey-text text-darken-2">Modifier</a></li>
                                    {!! Form::open(['method' => 'DELETE', 'route' => ['user.destroy', $user->id]]) !!}
                                    <li><a href="#!" onclick="$('#del_user{{ $user->id }}').click();" class="waves-effect waves-light grey-text text-darken-2">Supprimer</a></li>
                                    {!! Form::submit('Supprimer', ['id'=>'del_user'.$user->id,'class' => 'btn btn-danger btn-block hide', 'onclick' => 'return confirm(\'Vraiment supprimer cet utilisateur ?\')']) !!}
                                    {!! Form::close() !!}
                                </ul>
                            </tr>
                            @endif
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

@endsection