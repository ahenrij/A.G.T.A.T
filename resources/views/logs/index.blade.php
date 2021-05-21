@extends('layouts.app')
@section('content')
    <nav class="grey lighten-1 menu">
        <div class="nav-wrapper">
            <div class="col s12">
                <a href="{{ route('home') }}" class="breadcrumb"><i class="material-icons">home</i></a>
                <a href="#!" class="breadcrumb">Journal des opérations</a>
            </div>
        </div>
    </nav>

    <div class="row">

        <div class="col s12">
            <div class="card">
                <div class="card-content">
                    <table id="search_table">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Type</th>
                            <th>Message</th>
                            <th>Utilisateur</th>
                            <th>Date</th>
                            <th style="max-width: 5%">#</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($logs as $log)
                            <?php
                            $class = "";
                            if ($log->type_log == LOG_INFORMATION) {
                                $line = "<i class='material-icons blue-text text-lighten-1' title='Information'>info</i>";
                            } elseif ($log->type_log == LOG_MODIFICATION) {
                                $line = "<i class='material-icons orange-text' title='Modification'>warning</i>";
                            } elseif ($log->type_log == LOG_SUPPRESSION) {
                                $line = "<i class='material-icons red-text' title='Suppression'>delete</i>";
                            } elseif ($log->type_log == LOG_CAISSE_FERMEE) {
                                $line = "<i class='material-icons green-text' title='Caisse'>money_off</i>";
                            }
                            ?>

                            <tr>
                                <td style="width: 6%">{{ isset($i) ? ++$i : $i=1 }}</td>
                                <td style="width: 6%">{!! $line !!}</td>
                                <td style="width: 45%">{{ substr(nl2br($log->message),0,50) . ' ... ' }}</td>
                                <td style="width: 25%">{{ $log->user->prenom. ' ' .$log->user->nom  }}</td>
                                <td style="width: 20%">{{ date("d/m/Y à H:i", strtotime($log->date_log))}}</td>
                                <td style="max-width: 5%"><a href="{{ route('log.show', $log->id) }}"
                                                              class="waves-effect dropdown-button btn btn-flat blue-grey-text text-darken-4">Lire</a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection