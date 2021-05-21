@extends('layouts.app')

@section('content')
    <?php use \Illuminate\Support\Facades\Request; ?>

    <nav class="grey lighten-1 menu">
        <div class="nav-wrapper">
            <div class="col s12">
                <a href="{{ route('home') }}" class="breadcrumb"><i class="material-icons">home</i></a>
                <a href="#!" class="breadcrumb">Demandes</a>
                <a href="{{ route('demandes') }}" class="breadcrumb">Mes demandes</a>
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
        <div class="col s12">
            <div class="card">
                <div class="card-image">
                    <a href="{{ route('demande.create') }}"
                       class="btn-floating halfway-fab btn-large waves-effect waves-light green"><i
                                class="material-icons">add</i></a>
                </div>
                <div class="card-content">
                    <table id="search_table">
                        <thead>
                        <tr>
                            {{--<th>#</th>--}}
                            <th class="text-center">N °</th>
                            <th>Zone</th>
                            <th>Type</th>
                            <th>Durée</th>
                            <th>Coût</th>
                            <th>Date de demande</th>
                            <th style="max-width: 10px">#</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($demandes as $demande)
                            <tr>
                                {{--<td style="width: 5%">{{ isset($i) ? ++$i : $i=1 }}</td>--}}
                                <td style="width: 13%">{{ $demande->numero }}</td>
                                <td style="width: 17%">{{ $demande->zone->libelle }}</td>
                                <td style="width: 15%">{{ ($demande->typeTitre->code == 'MT') ? 'Macaron' : 'Badge' }}</td>
                                <td style="width: 15%">{{ (intval($demande->duree)/24). ' jour(s)' }}</td>
                                <td style="width: 17%">{{ $demande->cout }} F CFA</td>
                                <td style="width: 20%">{{ date('d/m/Y à H:i', strtotime($demande->created_at)) }}</td>
                                <td style="max-width: 5px">
                                    @if($demande->etat == 'N')
                                    <a href="#!" class="waves-effect dropdown-button grey-text text-darken-1"
                                                              data-activates="dropdown_menu{{ $demande->id }}"><i class="material-icons">more_vert</i></a>
                                    @else
                                        <a href="#!"><i class="material-icons green white-text">check</i></a>
                                    @endif
                                </td>
                                @if($demande->etat == 'N')
                                    <ul id='dropdown_menu{{ $demande->id }}' class='dropdown-content'>
                                        <li><a href="{{ route('demande.show', [$demande->id]) }}"
                                               class="waves-effect waves-light grey-text text-darken-2">Voir</a>
                                        </li>
                                        {!! Form::open(['method' => 'DELETE', 'route' => ['titre.destroy', $demande->id]]) !!}
                                        <li><a href="#!" onclick="$('#del_titre{{ $demande->id }}').click();"
                                               class="waves-effect waves-light grey-text text-darken-2">Supprimer</a>
                                        </li>
                                        {!! Form::submit('Supprimer', ['id'=>'del_titre'.$demande->id,'class' => 'btn btn-danger btn-block hide', 'onclick' => 'return confirm(\'Vraiment supprimer ce titre d\\\'accès temporaire ?\')']) !!}
                                        {!! Form::close() !!}
                                    </ul>
                                @endif
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection