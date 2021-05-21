@extends('layouts.app')
@section('content')
    <nav class="grey lighten-1 menu hidden-print">
        <div class="nav-wrapper">
            <div class="col s12">
                <a href="{{ route('home') }}" class="breadcrumb"><i class="material-icons">home</i></a>
                <a href="{{ url('point/user') }}" class="breadcrumb">Points financiers</a>
                <a href="{{ url('point/user') }}" class="breadcrumb">Par distributeur</a>
            </div>
        </div>
    </nav>

    <div style="margin-top: 30px; padding: 2%">
        <div class="row">
            <div style="width: 35%;padding-left: 1%; float: left;" class="hidden-print">
                <ul class="collapsible popout" data-collapsible="accordion">
                    <li>
                        <div class="collapsible-header">
                            <i class="material-icons">search</i>
                            <h6> Rechercher </h6>
                        </div>
                        <div class="collapsible-body">
                            {{ Form::open(['url'=>'/point/user','method'=>'post']) }}
                            <div class="row">
                                <div class="col s6">
                                    {{ Form::label('Date de début') }}
                                    {{ Form::date('date_debut') }}
                                </div>
                                <div class="col s6">
                                    {{ Form::label('Date de fin') }}
                                    {{ Form::date('date_fin') }}
                                </div>
                            </div>
                            <div class="row">
                                <?php if(!empty($erreurs)){ ?>
                                <script type="text/javascript">
                                    window.onload = function () {
                                        $('.collapsible').collapsible('open', 0);
                                    }
                                </script>
                                <div class="red-text" style="font-size: 13px; padding-top: -5px">
                                    <?php foreach ($erreurs as $erreur) {
                                        echo $erreur;
                                    } ?>
                                </div>
                                <?php } ?>
                                {{ Form::submit('Valider',['class' => 'btn green lighten-1']) }}
                                {{ Form::close() }}
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
            <div class="indigo-text lighten-4" style="padding: 1%">
                <?php if ($point_user == null && empty($erreurs)) {
                    echo '<p> Il n\'y a pas eu de vente de titres concernant cette période. </p>';
                } ?>
            </div>
            <div>
                <img align="right" style="padding-right: 2%" src="{{URL::to('/')}}/img/imprimer.png" title="imprimer"
                     class="hidden-print"
                     alt="Imprimer" onclick="print()">
            </div>

        </div>
        <div class="row print-content">
            <div class="row  hide visible-print-block">
                <div class="col s2">
                    <img style="width: 120%;height: 120%; margin-left: 25%;margin-top: 40%"
                         src="{{URL::to('/')}}/img/logo.png" title="logo" alt="Logo">
                </div>
                <div class="col s9 visible-print-block  entete_print" align="center">
                    <p>REPUBLIQUE DU BENIN</p>
                    <p style="line-height: 2%">*******</p>
                    <p>MINISTERE DE L'ECONOMIE MARITIME ET DES INFRASTRUCTURES PORTUAIRES (MEMIP)</p>
                    <p style="line-height: 2%">*******</p>
                    <p>PORT AUTONOME DE COTONOU</p>
                    <p style="line-height: 2%">*******</p>
                    <p>DIRECTION DE LA CAPITAINERIE</p>
                    <p style="line-height: 2%">*******</p>
                    <p>SERVICE FORMALITE D'ACCES</p>
                </div>
            </div>
            <div class="row">
                <div class="hide visible-print-block titre_point" align="center">
                    <B style="text-decoration: underline; font-size: 21px"> POINT JOURNALIER DE VENTE DES TITRES D'ACCES
                        TEMPORAIRES</B>
                    <br>
                    <B style="font-size: 20px;">
                        @if($date_debut == $date_fin)
                            {{ ' EN DATE DU '. date('d / m / Y',strtotime($date_debut)) }}
                        @else
                            {{ 'Du ' . date('d/m/Y',strtotime($date_debut)) . ' AU ' . date('d/m/Y',strtotime($date_fin)) }}
                        @endif
                    </B>
                </div>
            </div>
            <div class="row">
                <div class="card">
                    <div class="card-content">
                        <table class="maTable">
                            <thead>
                            <tr>
                                <th rowspan="2">Utillisateur</th>
                                <th colspan="2">Nombre délivré</th>
                                <th colspan="2">Montant encaissé</th>
                                <th rowspan="2">Total encaissé</th>
                                <th rowspan="2">Visa Opérateur</th>
                            </tr>
                            <tr>
                                <th>Macaron</th>
                                <th>Badge</th>
                                <th>Macaron</th>
                                <th>Badge</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($point_user as $point)
                                <tr>
                                    <td style="width: 16%">
                                        {{ $point->prenom . ' ' . $point->nom }}
                                    </td>
                                    <td style="width: 15%">{{ $point->nombre_mac }}</td>
                                    <td style="width: 15%">{{ $point->nombre_badge }}</td>
                                    <td style="width: 18%">
                                        <?php if ($point->cout_mac == null) {
                                            $point->cout_mac = 0;
                                        } echo number_format($point->cout_mac); ?>
                                    </td>
                                    <td style="width: 18%">
                                        <?php if ($point->cout_badge == null) {
                                            $point->cout_badge = 0;
                                        } echo number_format($point->cout_badge); ?>
                                    </td>
                                    <td style="width: 18%">{{ ($point->cout_badge + $point->cout_mac)*1.18  }}</td>
                                    <td></td>
                                </tr>
                            @endforeach
                            @foreach($point_total as $point)
                                <tr>
                                    <td>Total Journalier</td>
                                    <td>{{ $point->nombre_mac }}</td>
                                    <td>{{ $point->nombre_badge }}</td>
                                    <td>{{ number_format($point->cout_mac) }}</td>
                                    <td>{{ number_format($point->cout_badge) }}</td>
                                    <td>{{ number_format(($point->cout_mac + $point->cout_badge)*1.18) }}</td>
                                    <td>Visa approbateur</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop