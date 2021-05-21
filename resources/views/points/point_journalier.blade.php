@extends('layouts.app')

@section('content')
    <nav class="grey lighten-1 menu hidden-print">
        <div class="nav-wrapper">
            <div class="col s12">
                <a href="{{ route('home') }}" class="breadcrumb"><i class="material-icons">home</i></a>
                <a href="{{ route('titre.index') }}" class="breadcrumb">Titres d'Accès</a>
                <a href="{{ url('point/journalier') }}" class="breadcrumb">Point journalier</a>
            </div>
        </div>
    </nav>
    <div style="margin-top: 30px; padding: 2%">
        <div class="row">
            <div class="red-text lighten-4" style="padding: 1%" align="center">

                <?php
                if ($point_tot_journalier == null && empty($erreurs)) {
                    echo '<b> Il n\'y a pas eu de vente de titres aujourd\'hui vous concernant </b>';
                } ?>
            </div>

        </div>
        <div class="row print-content">
            <div>
                <img align="right" style="padding-right: 2%; cursor: pointer" src="{{URL::to('/')}}/img/imprimer.png"
                     title="imprimer"
                     class="hidden-print"
                     alt="Imprimer" onclick="print()">
            </div>
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
                        {{ ' EN DATE DU '. date('d / m / Y',strtotime($date_debut)) }}
                    </B>
                </div>
            </div>
            <div class="row">
                <div class="card">
                    <div class="card-content">
                        <table class="maTable">
                            <thead class="head">
                            <tr>
                                <th>Heure</th>
                                <th>N° Titre</th>
                                <th>Bénéficiaire</th>
                                <th>Type de titre</th>
                                <th>Montant HT</th>
                                <th>Montant TTC</th>
                                <th class="hidden-print">#</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($point_det_journalier as $point)
                                <tr>
                                    <td>{{ date('H:i',strtotime($point->date_delivrance)) }}</td>
                                    <td>{{ $point->numero }}</td>
                                    <td>{{ $point->usager->prenom . ' ' .  $point->usager->nom }}</td>
                                    <td>{{ $point->typetitre->libelle }}</td>
                                    <td>{{ $point->cout }}</td>
                                    <td>{{ 1.18*$point->cout }}</td>
                                    <td class="hidden-print"><a href="#!"><i
                                                    class="material-icons">chevron_right</i></a></td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card">
                    <div class="card-content">
                        <table class="maTable">
                            <thead class="head">
                            <tr>
                                <th>Nbr. Mac. délivrés</th>
                                <th>Nbr. Badges délivrés</th>
                                <th>Coût Mac.. (HT)</th>
                                <th>Coût Badge (HT)</th>
                                <th>Montant TTC</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($point_tot_journalier as $point)
                                <tr>
                                    <td>{{ $point->nombre_mac }}</td>
                                    <td>{{ $point->nombre_badge }}</td>
                                    <td>
                                        <?php if ($point->cout_mac == null) {
                                            $point->cout_mac = 0;
                                        }
                                        echo number_format($point->cout_mac);
                                        ?>
                                    </td>
                                    <td>
                                        <?php if ($point->cout_badge == null) {
                                            $point->cout_badge = 0;
                                        }
                                        echo number_format($point->cout_badge);
                                        ?>
                                    </td>
                                    <td style="width: 18%">{{ number_format(($point->cout_badge + $point->cout_mac)*1.18)  }}</td>
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