
<li class="no-padding">
    <ul class="collapsible collapsible-accordion">
        <li class="bold">
            <a href="{{ url('/') }}" class="collapsible-header waves-effect"><i class="material-icons orange-text">widgets</i>
                Tableau de bord</a>
        </li>
        @if(in_array(Auth::user()->typeUser->libelle, array(USAGER_LABEL)))
            <li class="bold">
                <a class="collapsible-header waves-effect waves-orange">
                    <i class="material-icons orange-text">bookmark_border</i>Demandes</a>
                <div class="collapsible-body">
                    <ul class="grey lighten-5">
                        <li><a href="{{ route('demande.create') }}" class="waves-effect">Nouvelle</a></li>
                        <li><a href="{{ route('demande.index') }}" class="waves-effect">Mes demandes</a>
                        </li>
                        </li>
                    </ul>
                </div>
            </li>
        @endif

        @if(in_array(Auth::user()->typeUser->libelle, array(ADMIN_LABEL, DISTRIBUTEUR_LABEL)))
            <li class="bold">
                <a class="collapsible-header waves-effect waves-green">
                    <i class="material-icons orange-text">description</i>Titres d'Accès</a>
                <div class="collapsible-body">
                    <ul class="grey lighten-5">
                        <li><a href="{{ route('titre.create') }}" class="waves-effect">Nouveau</a></li>
                        <li><a href="{{ route('demandes') }}" class="waves-effect">Demandes
                                &nbsp;&nbsp;&nbsp;&nbsp;<span class="new badge green" data-badge-caption="nouvelles">{{ getDemandNbr() }}</span></a>
                        </li>
                        <li><a href="{{ route('point.journalier') }}" class="waves-effect">Point Journalier</a></li>
                        <li><a href="{{ route('titre.index') }}" class="waves-effect">Liste des T.A.T</a></li>
                    </ul>
                </div>
            </li>
        @endif

        @if(in_array(Auth::user()->typeUser->libelle, array(ADMIN_LABEL, CAISSIER_LABEL)))
            <li class="bold">
                <a class="collapsible-header waves-effect waves-yellow">{{--&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;--}}
                    <i class="material-icons orange-text">pie_chart</i>Points Financiers</a>
                <div class="collapsible-body no-padding">
                    <ul class="collapsible collapsible-accordion grey lighten-5">
                        <li><a class="collapsible-header">Global</a>
                            <div class="collapsible-body">
                                <ul class="grey lighten-4">
                                    <li>
                                        <a href="{{ url('/point/global') }}">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                            Réduit</a></li>
                                    <li>
                                        <a href="{{ url('/point/detail') }}">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                            Détaillé</a></li>
                                </ul>
                            </div>
                        </li>
                        <li><a href="{{ url('/point/groupe') }}" class="waves-effect">Par Groupe</a></li>
                        <li><a href="{{ url('/point/user') }}" class="waves-effect">Par Distributeur</a>
                        </li>
                    </ul>
                </div>
            </li>
            <li class="bold"><a href="{{ url('/caisse') }}" class="collapsible-header waves-effect">
                    <i class="material-icons orange-text">monetization_on</i>Caisse</a></li>
        @endif
    </ul>
</li>

@if(Auth::user()->typeUser->libelle == ADMIN_LABEL)
    <li>
        <div class="divider"></div>
    </li>
    <li><a class="subheader">Admin</a></li>
    <li><a href="{{ url('/configurations') }}" class="waves-effet"><i class="material-icons orange-text">settings</i>Configurations</a>
    </li>

    <li><a href="{{ route('user.index') }}" class="waves-effect"><i class="material-icons orange-text">people</i>Utilisateurs</a>
    </li>
    <li><a href="{{ route('log.index') }}" class="waves-effect"><i class="material-icons orange-text">history</i>Historique
            des opérations</a></li>
    <li><a href="{{ route('about') }}" class="waves-effect"><i class="material-icons orange-text">info_outline</i>A
            propos</a></li>
@endif