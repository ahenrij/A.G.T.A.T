@extends('layouts.app')

@section('content')
    <?php use \Illuminate\Support\Facades\Request; ?>

    <nav class="grey lighten-1 menu">
        <div class="nav-wrapper">
            <div class="col s12">
                <a href="{{ route('home') }}" class="breadcrumb"><i class="material-icons">home</i></a>
                <a href="{{ route('titre.index') }}" class="breadcrumb">Titres d'Accès</a>
                @if($demandes)
                    <a href="{{ route('demandes') }}" class="breadcrumb">Demandes</a>
                @else
                    <a href="{{ route('titre.index') }}" class="breadcrumb">Liste des T.A.T</a>
                @endif
            </div>
        </div>
    </nav>

    <div class="row">
        <div class="col s12">
            <div class="card">
                <div class="card-image">
                    <a href="{{ route('titre.create') }}"
                       class="btn-floating halfway-fab btn-large waves-effect waves-light green"><i
                                class="material-icons">add</i></a>
                </div>
                <div class="card-content">
                    <table id="search_table">
                        <thead>
                        <tr>
                            {{--<th>#</th>--}}
                            <th>N °</th>
                            <th>Bénéficiaire</th>
                            <th>Zone</th>
                            <th>Type</th>
                            <th>Durée</th>
                            @if(!$demandes)
                                <th>Date délivrance</th>
                            @else
                                <th>Date de demande</th>
                            @endif
                            @if(Request::route()->getName()!='demandes')
                                <th>Distributeur</th>
                            @endif
                            <th style="max-width: 10px">#</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($titres as $titre)
                            <tr class="{{ ($titre->etat==='V') ? '' : 'grey-text' }}">
                                {{--<td style="width: 5%">{{ isset($i) ? ++$i : $i=1 }}</td>--}}
                                <td style="width: 10%">{{ $titre->numero }}</td>
                                <td style="width: 20%">{{ $titre->usager->nom . ' ' . $titre->usager->prenom }}</td>
                                <td style="width: {{ ($demandes) ? 15:8 }}%">{{ $titre->zone->libelle }}</td>
                                <td style="width: 17%">{{ ($titre->typeTitre->code == 'MT') ? 'Macaron' : 'Badge' }}</td>
                                <td style="width: {{ ($demandes) ? 15:8 }}%">{{ (intval($titre->duree)/24). ' jours' }}</td>
                                @if(!$demandes)
                                    <td style="width: 20%">{{ date('d/m/Y à H:i', strtotime($titre->date_delivrance)) }}</td>
                                @else
                                    <td style="width: 20%">{{ date('d/m/Y à H:i', strtotime($titre->created_at)) }}</td>
                                @endif
                                @if(!$demandes)
                                    <td style="width: 20%">{{ $titre->agent->nom . ' ' . $titre->agent->prenom }}</td>
                                @endif
                                <td style="max-width: 5px"><a href="#!"
                                                              class="waves-effect dropdown-button grey-text text-darken-1"
                                                              data-activates="dropdown_menu{{ $titre->id }}"><i
                                                class="material-icons">more_vert</i></a>
                                </td>
                                <ul id='dropdown_menu{{ $titre->id }}' class='dropdown-content'>
                                    @if(!$demandes)
                                        <li><a href="{{ route('demande.show', [$titre->id]) }}"
                                               class="waves-effect waves-light grey-text text-darken-2">Voir</a></li>
                                        <li><a href="{{ route('titre.show', [$titre->id]) }}"
                                               class="waves-effect waves-light grey-text text-darken-2">Imprimer</a>
                                        </li>
                                        {{-- <li><a href="{{ route('titre.edit', [$titre->id]) }}"
                                                class="waves-effect waves-light grey-text text-darken-2">Modifier</a>
                                         </li>--}}
                                    @else
                                        <li><a href="{{ route('demande.show', [$titre->id]) }}"
                                               class="waves-effect waves-light grey-text text-darken-2">Voir</a></li>
                                    @endif
                                    {!! Form::open(['method' => 'DELETE', 'route' => ['titre.destroy', $titre->id]]) !!}
                                    <li><a href="#!" onclick="$('#del_titre{{ $titre->id }}').click();"
                                           class="waves-effect waves-light grey-text text-darken-2">Supprimer</a></li>
                                    {!! Form::submit('Supprimer', ['id'=>'del_titre'.$titre->id,'class' => 'btn btn-danger btn-block hide', 'onclick' => 'return confirm(\'Vraiment supprimer ce titre d\\\'accès temporaire ?\')']) !!}
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
@endsection