<a href="#" data-activates="slide-out" class="button-collapse"><i class="material-icons">menu</i></a>
<a href="{{ url('/') }}" class="brand-logo" style="padding-left: 15px; font-size: 1.5em">AGTAT - PAC</a>

<ul id="nav-mobile" class="right hide-on-med-and-down" style="padding-right: 20px">
    @if(Auth::user()->typeUser->libelle == ADMIN_LABEL || Auth::user()->typeUser->libelle == DISTRIBUTEUR_LABEL)
        <li style="margin-right: 15px">
            <a class='dropdown-button' href='#!' data-activates='dropdown_demandes' id="drop_notif">
                <i class="material-icons icon-notif left" style="float: left; margin-right: 0px; max-width: 15px;">notifications_active</i>
                <span class="badge red white-text" style="margin-left: 0px;position: absolute; top: 10px; font-size: 13px; border-radius: 50%; padding-left:0px; padding-top: 2px; padding-bottom: 2px; padding-right: 0px;min-width:0px;width: 23px; height: 23px">{{ getDemandNbr() }}</span>
            </a>
        </li>

        <?php
            $liste = getLastDemandes(5);
        ?>

        <ul id='dropdown_demandes' class='dropdown-content'>
            <li><a href="#!" class="grey-text text-darken-3 bold">NOTIFICATIONS
                    &nbsp;&nbsp;&nbsp;&nbsp;<span class="new badge red" data-badge-caption="en attente">{{ getDemandNbr() }}</span></a></li>
            <li class="divider"></li>
        @foreach($liste as $demande)
            <li><a href="{{ route('demande.show', [$demande->id]) }}" class="orange-text">{{ $demande->prenom.' '.$demande->nom }},
                    <span style="font-size: 12px" class="grey-text  text-darken-1">{{ date('d/m/y à H:i',strtotime($demande->created_at)) }}</span></a></li>
            @endforeach
            <li class="divider"></li>
            <li><a class="grey-text text-darken-2" href="{{ route('demandes') }}"><i class="material-icons orange-text text-lighten-2">description</i>Toutes les demandes</a></li>
        </ul>
    @endif
    <li><a href="{{ route('about') }}">A propos</a></li>
</ul>