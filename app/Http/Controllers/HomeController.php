<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use App\Titre;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('caissier', ['only' => ['caisse', 'close_caisse']]);
        $this->middleware('admin', ['only' => ['configurations']]);
    }

    public function index()
    {
        $nombre_titres = DB::table('titres')->select()->count();
        $nombre_badges = DB::table('titres')->join('type_titres', 'titres.type_titre_id', '=', 'type_titres.id')
            ->where('type_titres.libelle', 'like', 'Badge %')->select()->count();
        $nombre_macarons = DB::table('titres')->join('type_titres', 'titres.type_titre_id', '=', 'type_titres.id')
            ->where('type_titres.libelle', 'like', 'Macaron %')->select()->count();

        //Titres pourcentages

        $prcent_badge = ($nombre_badges / $nombre_titres) * 100;
        $prcent_macaron = ($nombre_macarons / $nombre_titres) * 100;

        //Nombre de titres par mois

        $nombreBadgesByMonth = $this->getMonthlyStats('Badge');
        $nombreMacaronsByMonth = $this->getMonthlyStats('Macaron');

        $monthsOfYear = ["Janvier", "Février", "Mars", "Avril", "Mai", "Juin", "Juillet", "Août", "Septembre", "Octobre", "Novembre", "Décembre"];

        if (Auth::user()->typeUser->libelle === USAGER_LABEL) {

            $nombre_demandes_encours = Titre::Where(['demande' => 1, 'usager_id' => Auth::user()->id, 'etat' => 'N'])->count();
            $nombre_demandes_validees = Titre::Where(['demande' => 1, 'usager_id' => Auth::user()->id, 'etat' => 'V'])->count();
            $nombre_titres_achetes = Titre::Where(['usager_id' => Auth::user()->id, 'etat' => 'V'])->count();

            return view('dashboard.usager', compact('nombre_demandes_encours', 'nombre_demandes_validees', 'nombre_titres_achetes'));
        } else {
            return view('dashboard.index', compact('nombre_titres', 'nombre_macarons', 'nombre_badges', 'prcent_badge', 'prcent_macaron', 'nombreBadgesByMonth', 'nombreMacaronsByMonth', 'monthsOfYear'));
        }
    }

    private function getMonthlyStats($typeTitre)
    {
        return DB::table('titres')
            ->join('type_titres', 'titres.type_titre_id', '=', 'type_titres.id')
            ->select(DB::raw("MONTH(date_delivrance) as mois"), DB::raw("count(*) as nombre"))
            ->where('type_titres.libelle', 'like', "$typeTitre %")
            ->whereBetween(DB::raw('MONTH(date_delivrance)'), array(1, 12))
            ->groupBy(DB::raw('MONTH(date_delivrance)'))
            ->orderBy(DB::raw('MONTH(date_delivrance)'))
            ->get();
    }

    public function caisse()
    {

        $date_today = date('Y-m-d H:i:s');
        $annee = date('Y');

        $total_jour = DB::table('titres')->whereDate('date_delivrance', '=', date('Y-m-d'))->select()->sum('cout');
        $total_annee = DB::table('titres')->whereBetween('date_delivrance', array($annee . '-01-01', $date_today))->select()->sum('cout');

        return view('caisse.index', compact('total_jour', 'total_annee'));
    }

    public function close_caisse()
    {
        if (!caisseIsClosed()) {
            save_trace("Fermeture de caisse", LOG_CAISSE_FERMEE);
        }
        return redirect('caisse')->withOk("La caisse a été fermée.");
    }

    public function configurations()
    {
        $nombre_zone = DB::table('zones')->select()->count();
        $nombre_groupe = DB::table('groupes')->select()->count();
        $nombre_vehicule = DB::table('vehicules')->select()->count();
        $nombre_structure = DB::table('structures')->select()->count();
        $nombre_ttitre = DB::table('type_titres')->select()->count();
        $nombre_tvehicule = DB::table('type_vehicules')->select()->count();
        $nombre_tuser = DB::table('type_users')->select()->count();

        return view('configurations.index', compact('nombre_zone', 'nombre_groupe', 'nombre_vehicule', 'nombre_structure', 'nombre_ttitre', 'nombre_tvehicule', 'nombre_tuser'));
    }

    public function about()
    {
        return view('layouts.about');
    }

}
