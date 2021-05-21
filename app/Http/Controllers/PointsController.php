<?php

namespace App\Http\Controllers;

use App\Titre;
use Faker\Provider\cs_CZ\DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

use App\Http\Requests;

class PointsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('caissier');
    }

    public function index(Request $request)
    {
        $erreurs = [];
        $date_debut = date('Y-m-d 00:00:00');
        $date_fin = date('Y-m-d 23:59:59.999');

        //Si une recherche est faite
        if (isset($_POST['date_debut']) && isset($_POST['date_fin'])) {
            $date_debut = date('Y-m-d 00:00:00', strtotime($request->input('date_debut')));
            $date_fin = date('Y-m-d 23:59:59.999', strtotime($request->input('date_fin')));
            if (empty($_POST['date_debut']) || empty($_POST['date_fin'])) {
                $erreurs['empty'] = 'Veuillez renseigner tous les champs';
            } elseif ($date_fin < $date_debut) {
                $erreurs['date_invalide'] = 'La date de fin doit être supérieure à la date de début';
            }
        }

        $dates_delivrance = DB::table('titres')->select('date_delivrance')
            ->whereBetween('date_delivrance', array($date_debut, $date_fin))
            ->groupBy('date_delivrance')
            ->orderBy('date_delivrance')
            ->distinct()
            ->get();

        foreach ($dates_delivrance as $date_delivrance) {
            $point_vente = DB::table('titres')->select('date_delivrance',
                DB::raw("(SELECT count(*) FROM titres,type_titres WHERE titres.type_titre_id = type_titres.id AND libelle LIKE 'Badge %' AND date_delivrance = '" . date('Y-m-d', strtotime($date_delivrance->date_delivrance)) . "') as nombre_badge"),
                DB::raw("(SELECT count(*) FROM titres,type_titres WHERE titres.type_titre_id = type_titres.id AND libelle LIKE 'Macaron %' AND date_delivrance = '" . date('Y-m-d', strtotime($date_delivrance->date_delivrance)) . "') as nombre_mac"),
                DB::raw("(SELECT SUM(cout) FROM titres,type_titres WHERE titres.type_titre_id = type_titres.id AND libelle LIKE 'Badge %' AND date_delivrance = '" . date('Y-m-d', strtotime($date_delivrance->date_delivrance)) . "') as cout_badge"),
                DB::raw("(SELECT SUM(cout) FROM titres,type_titres WHERE titres.type_titre_id = type_titres.id AND libelle LIKE 'Macaron %' AND date_delivrance = '" . date('Y-m-d', strtotime($date_delivrance->date_delivrance)) . "') as cout_mac"))
                ->join('type_titres', 'titres.type_titre_id', '=', 'type_titres.id')
                ->where('date_delivrance', '=', date('Y-m-d', strtotime($date_delivrance->date_delivrance)))
                ->groupBy('date_delivrance')
                ->orderBy('date_delivrance')
                ->distinct()
                ->get();
        }

        $point_global = DB::table('titres')->select('date_delivrance',
            DB::raw("(SELECT count(*) FROM titres,type_titres WHERE titres.type_titre_id = type_titres.id AND libelle LIKE 'Badge %' AND date_delivrance between '" . $date_debut . "' AND '" . $date_fin . "') as nombre_badge"),
            DB::raw("(SELECT count(*) FROM titres,type_titres WHERE titres.type_titre_id = type_titres.id AND libelle LIKE 'Macaron %' AND date_delivrance between '" . $date_debut . "' AND '" . $date_fin . "') as nombre_mac"),
            DB::raw("(SELECT SUM(cout) FROM titres,type_titres WHERE titres.type_titre_id = type_titres.id AND libelle LIKE 'Badge %' AND date_delivrance between '" . $date_debut . "' AND '" . $date_fin . "') as cout_badge"),
            DB::raw("(SELECT SUM(cout) FROM titres,type_titres WHERE titres.type_titre_id = type_titres.id AND libelle LIKE 'Macaron %' AND date_delivrance between '" . $date_debut . "' AND '" . $date_fin . "') as cout_mac"))
            ->join('type_titres', 'titres.type_titre_id', '=', 'type_titres.id')
            ->whereBetween('date_delivrance', array($date_debut, $date_fin))
            ->orderBy('date_delivrance')
            ->distinct()
            ->limit(1)
            ->get();

        return view('points.point_global', compact('point_global', 'date_debut', 'date_fin', 'erreurs', 'dates_delivrance'));
    }


    public function detail(Request $request)
    {

        $erreurs = [];
        if (isset($_POST['date_debut']) && isset($_POST['date_fin'])) {
            $date_debut = date('Y-m-d 00:00:00', strtotime($request->input('date_debut')));
            $date_fin = date('Y-m-d 23:59:59.999', strtotime($request->input('date_fin')));
            if (empty($_POST['date_debut']) || empty($_POST['date_fin'])) {
                $erreurs['empty'] = 'Veuillez renseigner tous les champs';
            } elseif ($date_fin < $date_debut) {
                $erreurs['date_invalide'] = 'La date de fin doit être supérieure à la date de début';
            }
        } else {
            $date_debut = date('Y-m-d 00:00:00');
            $date_fin = date('Y-m-d 23:59:59.999');
        }

        $point_detaille = Titre::where('date_delivrance', '>=', $date_debut)->where('date_delivrance', '<=', $date_fin)->orderBy('date_delivrance')->get();


        $point_total = DB::table('titres')->select('date_delivrance',
            DB::raw("(SELECT count(*) FROM titres,type_titres WHERE titres.type_titre_id = type_titres.id AND libelle LIKE 'Badge %' AND date_delivrance between '" . $date_debut . "' AND '" . $date_fin . "') as nombre_badge"),
            DB::raw("(SELECT count(*) FROM titres,type_titres WHERE titres.type_titre_id = type_titres.id AND libelle LIKE 'Macaron %' AND date_delivrance between '" . $date_debut . "' AND '" . $date_fin . "') as nombre_mac"),
            DB::raw("(SELECT SUM(cout) FROM titres,type_titres WHERE titres.type_titre_id = type_titres.id AND libelle LIKE 'Badge %' AND date_delivrance between '" . $date_debut . "' AND '" . $date_fin . "') as cout_badge"),
            DB::raw("(SELECT SUM(cout) FROM titres,type_titres WHERE titres.type_titre_id = type_titres.id AND libelle LIKE 'Macaron %' AND date_delivrance between '" . $date_debut . "' AND '" . $date_fin . "') as cout_mac"))
            ->join('type_titres', 'titres.type_titre_id', '=', 'type_titres.id')
            ->whereBetween('date_delivrance', array($date_debut, $date_fin))
            ->orderBy('date_delivrance')
            ->distinct()
            ->limit(1)
            ->get();

        return view('points.point_detaille', compact('point_detaille', 'point_total', 'date_debut', 'date_fin', 'erreurs'));
    }


    public function groupe(Request $request)
    {

        $erreurs = [];
        if (isset($_POST['date_debut']) && isset($_POST['date_fin'])) {
            $date_debut = date('Y-m-d 00:00:00', strtotime($request->input('date_debut')));
            $date_fin = date('Y-m-d 23:59:59.999', strtotime($request->input('date_fin')));
            if (empty($_POST['date_debut']) || empty($_POST['date_fin'])) {
                $erreurs['empty'] = 'Veuillez renseigner tous les champs';
            } elseif ($date_fin < $date_debut) {
                $erreurs['date_invalide'] = 'La date de fin doit être supérieure à la date de début';
            }
        } else {
            $date_debut = date('Y-m-d 00:00:00');
            $date_fin = date('Y-m-d 23:59:59.999');
        }


        $point_groupe = DB::table('titres')->select('groupes.libelle',
            DB::raw("(SELECT count(*) FROM titres,type_titres WHERE titres.type_titre_id = type_titres.id AND titres.agent_id = users.id AND users.groupe_id = groupes.id AND type_titres.libelle LIKE 'Badge %' AND date_delivrance between '" . $date_debut . "' AND '" . $date_fin . "') as nombre_badge"),
            DB::raw("(SELECT count(*) FROM titres,type_titres WHERE titres.type_titre_id = type_titres.id AND titres.agent_id = users.id AND users.groupe_id = groupes.id AND type_titres.libelle LIKE 'Macaron %' AND date_delivrance between '" . $date_debut . "' AND '" . $date_fin . "') as nombre_mac"),
            DB::raw("(SELECT SUM(cout) FROM titres,type_titres WHERE titres.type_titre_id = type_titres.id AND titres.agent_id = users.id AND users.groupe_id = groupes.id AND type_titres.libelle LIKE 'Badge %'  AND date_delivrance between '" . $date_debut . "' AND '" . $date_fin . "') as cout_badge"),
            DB::raw("(SELECT SUM(cout) FROM titres,type_titres WHERE titres.type_titre_id = type_titres.id AND titres.agent_id = users.id AND users.groupe_id = groupes.id AND type_titres.libelle LIKE 'Macaron %' AND date_delivrance between '" . $date_debut . "' AND '" . $date_fin . "') as cout_mac"))
            ->join('type_titres', 'titres.type_titre_id', '=', 'type_titres.id')
            ->join('users', 'users.id', '=', 'titres.agent_id')
            ->join('groupes', 'users.groupe_id', '=', 'groupes.id')
            ->whereBetween('date_delivrance', array($date_debut, $date_fin))
            ->groupBy('groupes.id')
            ->orderBy('groupes.id')
            ->distinct()
            ->get();
        $point_total = DB::table('titres')->select(
            DB::raw("(SELECT count(*) FROM titres,type_titres WHERE titres.type_titre_id = type_titres.id AND type_titres.libelle LIKE 'Badge %' AND date_delivrance between '" . $date_debut . "' AND '" . $date_fin . "') as nombre_badge"),
            DB::raw("(SELECT count(*) FROM titres,type_titres WHERE titres.type_titre_id = type_titres.id AND type_titres.libelle LIKE 'Macaron %' AND date_delivrance between '" . $date_debut . "' AND '" . $date_fin . "') as nombre_mac"),
            DB::raw("(SELECT SUM(cout) FROM titres,type_titres WHERE titres.type_titre_id = type_titres.id AND type_titres.libelle LIKE 'Badge %'  AND date_delivrance between '" . $date_debut . "' AND '" . $date_fin . "') as cout_badge"),
            DB::raw("(SELECT SUM(cout) FROM titres,type_titres WHERE titres.type_titre_id = type_titres.id AND type_titres.libelle LIKE 'Macaron %' AND date_delivrance between '" . $date_debut . "' AND '" . $date_fin . "') as cout_mac"))
            ->join('type_titres', 'titres.type_titre_id', '=', 'type_titres.id')
            ->join('users', 'users.id', '=', 'titres.agent_id')
            ->join('groupes', 'users.groupe_id', '=', 'groupes.id')
            ->whereBetween('date_delivrance', array($date_debut, $date_fin))
            ->groupBy('groupes.id')
            ->distinct()
            ->get();

        return view('points.point_groupe', compact('point_groupe', 'point_total', 'date_debut', 'date_fin', 'erreurs'));
    }

    public function user(Request $request)
    {

        $erreurs = [];
        if (isset($_POST['date_debut']) && isset($_POST['date_fin'])) {
            $date_debut = date('Y-m-d 00:00:00', strtotime($request->input('date_debut')));
            $date_fin = date('Y-m-d 23:59:59.999', strtotime($request->input('date_fin')));
            if (empty($_POST['date_debut']) || empty($_POST['date_fin'])) {
                $erreurs['empty'] = 'Veuillez renseigner tous les champs';
            } elseif ($date_fin < $date_debut) {
                $erreurs['date_invalide'] = 'La date de fin doit être supérieure à la date de début';
            }
        } else {
            $date_debut = date('Y-m-d 00:00:00');
            $date_fin = date('Y-m-d 23:59:59.999');
        }


        $point_user = DB::table('titres')->select('nom', 'prenom',
            DB::raw("(SELECT count(*) FROM titres,type_titres WHERE titres.type_titre_id = type_titres.id AND titres.agent_id = users.id AND type_titres.libelle LIKE 'Badge %' AND date_delivrance between '" . $date_debut . "' AND '" . $date_fin . "') as nombre_badge"),
            DB::raw("(SELECT count(*) FROM titres,type_titres WHERE titres.type_titre_id = type_titres.id AND titres.agent_id = users.id AND type_titres.libelle LIKE 'Macaron %' AND date_delivrance between '" . $date_debut . "' AND '" . $date_fin . "') as nombre_mac"),
            DB::raw("(SELECT SUM(cout) FROM titres,type_titres WHERE titres.type_titre_id = type_titres.id AND titres.agent_id = users.id AND type_titres.libelle LIKE 'Badge %'  AND date_delivrance between '" . $date_debut . "' AND '" . $date_fin . "') as cout_badge"),
            DB::raw("(SELECT SUM(cout) FROM titres,type_titres WHERE titres.type_titre_id = type_titres.id AND titres.agent_id = users.id AND type_titres.libelle LIKE 'Macaron %' AND date_delivrance between '" . $date_debut . "' AND '" . $date_fin . "') as cout_mac"))
            ->join('type_titres', 'titres.type_titre_id', '=', 'type_titres.id')
            ->join('users', 'users.id', '=', 'titres.agent_id')
            ->whereBetween('date_delivrance', array($date_debut, $date_fin))
            ->groupBy('users.id')
            ->orderBy('users.id')
            ->distinct()
            ->get();
        $point_total = DB::table('titres')->select(
            DB::raw("(SELECT count(*) FROM titres,type_titres WHERE titres.type_titre_id = type_titres.id AND type_titres.libelle LIKE 'Badge %' AND date_delivrance between '" . $date_debut . "' AND '" . $date_fin . "') as nombre_badge"),
            DB::raw("(SELECT count(*) FROM titres,type_titres WHERE titres.type_titre_id = type_titres.id AND type_titres.libelle LIKE 'Macaron %' AND date_delivrance between '" . $date_debut . "' AND '" . $date_fin . "') as nombre_mac"),
            DB::raw("(SELECT SUM(cout) FROM titres,type_titres WHERE titres.type_titre_id = type_titres.id AND type_titres.libelle LIKE 'Badge %'  AND date_delivrance between '" . $date_debut . "' AND '" . $date_fin . "') as cout_badge"),
            DB::raw("(SELECT SUM(cout) FROM titres,type_titres WHERE titres.type_titre_id = type_titres.id AND type_titres.libelle LIKE 'Macaron %' AND date_delivrance between '" . $date_debut . "' AND '" . $date_fin . "') as cout_mac"))
            ->join('type_titres', 'titres.type_titre_id', '=', 'type_titres.id')
            ->join('users', 'users.id', '=', 'titres.agent_id')
            ->whereBetween('date_delivrance', array($date_debut, $date_fin))
            ->groupBy('users.id')
            ->distinct()
            ->get();

        return view('points.point_user', compact('point_user', 'point_total', 'date_debut', 'date_fin', 'erreurs'));
    }

    public function journalier()
    {

        $date_debut = date('Y-m-d 00:00:00');
        $date_fin = date('Y-m-d 23:59:59.999');
        $id_user = Auth::user()->id;

        $point_tot_journalier = DB::table('titres')->select(
            DB::raw("(SELECT count(*) FROM titres,type_titres WHERE titres.type_titre_id = type_titres.id AND titres.agent_id = users.id AND libelle LIKE 'Badge %' AND date_delivrance between '" . $date_debut . "' AND '" . $date_fin . "') as nombre_badge"),
            DB::raw("(SELECT count(*) FROM titres,type_titres WHERE titres.type_titre_id = type_titres.id AND titres.agent_id = users.id AND libelle LIKE 'Macaron %' AND date_delivrance between '" . $date_debut . "' AND '" . $date_fin . "') as nombre_mac"),
            DB::raw("(SELECT SUM(cout) FROM titres,type_titres WHERE titres.type_titre_id = type_titres.id AND titres.agent_id = users.id AND libelle LIKE 'Badge %' AND date_delivrance between '" . $date_debut . "' AND '" . $date_fin . "') as cout_badge"),
            DB::raw("(SELECT SUM(cout) FROM titres,type_titres WHERE titres.type_titre_id = type_titres.id AND titres.agent_id = users.id AND libelle LIKE 'Macaron %' AND date_delivrance between '" . $date_debut . "' AND '" . $date_fin . "') as cout_mac"))
            ->join('type_titres', 'titres.type_titre_id', '=', 'type_titres.id')
            ->join('users', 'titres.agent_id', '=', 'users.id')
            ->whereBetween('date_delivrance', array($date_debut, $date_fin))
            ->where('titres.agent_id', '=', $id_user)
            ->distinct()
            ->get();

        $point_det_journalier = Titre::where('date_delivrance', '>=', $date_debut)->where('date_delivrance', '<=', $date_fin)->where('titres.agent_id', '=', $id_user)->orderBy('date_delivrance')->get();

        save_trace("Consultation du point journalier", LOG_INFORMATION);
        return view('points.point_journalier', compact('point_tot_journalier', 'point_det_journalier', 'date_debut', 'date_fin'));
    }

}
