@extends('layouts.app')

@section('content')

    <nav class="grey lighten-1 menu">
        <div class="nav-wrapper">
            <div class="col s12">
                <a href="{{ route('home') }}" class="breadcrumb"><i class="material-icons">home</i></a>
                <a href="{{ route('log.index') }}" class="breadcrumb">Journal des opérations</a>
                <a href="#!" class="breadcrumb">Fiche</a>
            </div>
        </div>
    </nav>

    <div class="row" style="margin-top: 50px">
        <div class="col s8 offset-s2">
            <div class="card">
                <div class="card-content">
                    <h5>Journal -
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
                        echo $line;
                        ?>
                      </h5>
                    <div style="text-align: justify"> {{ $log->message }} </div>
                    <div style="text-align: right" class="blue-grey-text"> {{  date("d/m/Y à H:i",strtotime($log->date_log)) ."\n" .' par ' . $log->user->prenom . ' ' . $log->user->nom }}  </div>
                </div>
            </div>
            {{--<a href="javascript:history.back()" class="btn center">Retour</a>--}}
        </div>
    </div>
@endsection