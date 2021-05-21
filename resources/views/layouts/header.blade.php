 <li>
    <div class="user-view">
        <div class="background blue-grey lighten-1">{{--<img src="img/header.jpg">--}}</div>
        <img class="circle card grey lighten-2" src="{{ profil_link(Auth::user()->profil) }}"/>

        <a class="dropdown-button" data-activates="dropdown_user"><span
                    class="white-text name">
                {{ Auth::user()->prenom.' '.Auth::user()->nom }}<i
                        class="material-icons right">arrow_drop_down</i></span></a>
        <ul id="dropdown_user" class="dropdown-content">
            <li><a href="{{ url('/logout') }}" class="waves-effect">Déconnexion</a></li>
        </ul>
        @if(Auth::user()->groupe->libelle == AUCUN_GROUPE)
            <span class="white-text email">{{  Auth::user()->typeUser->libelle }}</span>
        @else
            <span class="white-text email">{{  Auth::user()->typeUser->libelle.', '.Auth::user()->groupe->libelle }}</span>
        @endif
    </div>
</li>