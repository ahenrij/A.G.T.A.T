@extends('layouts.app')

@section('content')

    <nav class="grey lighten-1 menu">
        <div class="nav-wrapper">
            <div class="col s12">
                <a href="{{ route('home') }}" class="breadcrumb"><i class="material-icons">home</i></a>
                @if($titre->etat == 'N' && $titre->demande == '1')
                    <a href="{{ route('titre.index') }}" class="breadcrumb">Titres d'Accès</a>
                    <a href="{{ route('titre.index') }}" class="breadcrumb">Demandes</a>
                @else
                    <a href="{{ route('titre.index') }}" class="breadcrumb">Titres d'Accès</a>
                    <a href="{{ route('titre.index') }}" class="breadcrumb">Liste des TAT</a>
                @endif
                <a href="#!" class="breadcrumb">Fiche n°{{ $titre->numero }}</a>
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
        <?php session()->forget('ok'); ?>
    @endif

    <div class="row" style="margin-top: 20px">
        <div class="col s12 m8 offset-m2">
            <div class="card">
                <div class="card-content">
                    <h4>n° {{ substr("0000000", 0, 7- strlen($titre->numero)) . $titre->numero }}</h4><br>
                    <table>
                        <tr>
                            <td>
                                <p><b>Bénéficiaire : </b>{{ $titre->usager->prenom.' '.$titre->usager->nom }}</p><br>
                                <p><b>Type de titre : </b>{{ ($titre->typeTitre->code == 'MT') ? 'Macaron' : 'Badge' }}
                                </p><br>
                                <p><b>Pièce Justificative : </b>{{ pieceJustificatifs()[$titre->piece] }}</p><br>
                                <p><b>Zone : </b>{{ $titre->zone->libelle }}</p><br>
                            </td>
                            <td>
                                @if($titre->etat == 'N' && $titre->demande == '1')
                                    <p><b>Date de demande : </b>{{ date('d/m/Y à H:i', strtotime($titre->created_at)) }}
                                    </p><br>
                                @else
                                    <p><b>Date de délivrance
                                            : </b>{{ date('d/m/Y à H:i', strtotime($titre->date_delivrance)) }}</p><br>
                                @endif
                                <p><b>Durée : </b>{{ intval($titre->duree)/24 }} jour(s)</p><br>
                                <p><b>Coût (HT) : </b>{{ $titre->cout }} F CFA</p><br>
                                <p><b>Coût (TTC) : </b>{{ $titre->cout*1.18 }} F CFA</p><br>
                                @if($titre->etat == 'V')
                                    <p><b>Distributeur : </b>{{  $titre->agent->prenom.' '.$titre->agent->nom }}</p><br>
                                @endif
                            </td>
                        </tr>
                    </table>

                </div>
                <div class="card-action right-align grey lighten-5">
                    <a href="#!" onclick="$('#del_titre{{ $titre->id }}').click();">Supprimer</a>
                    @if($titre->etat == 'N' && $titre->demande == '1')
                        <a href="{{ route('titre.validate', [$titre->id]) }}">Valider</a>
                    @else
                        <a href="{{ route('titre.show', [$titre->id]) }}">Imprimer</a>
                    @endif
                    {!! Form::open(['method' => 'DELETE', 'route' => ['titre.destroy', $titre->id]]) !!}
                    {!! Form::submit('Supprimer', ['id'=>'del_titre'.$titre->id,'class' => 'btn btn-danger btn-block hide', 'onclick' => 'return confirm(\'Vraiment supprimer ce titre d\\\'accès temporaire ?\')']) !!}
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection