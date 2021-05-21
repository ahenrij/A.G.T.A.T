<?php

namespace App\Http\Controllers;

use App\Groupe;
use App\Http\Requests\TitreCreateRequest;
use App\Structure;
use App\Titre;
use App\TypeTitre;
use App\TypeUser;
use App\TypeVehicule;
use App\User;
use App\Vehicule;
use App\Zone;
use App\Repositories\TitreRepository;

use App\Http\Requests\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TitreController extends Controller
{

    protected $titre;
    protected $titreRepository;

    public function __construct(TitreRepository $titreRepository)
    {
        $this->middleware('auth');
        $this->middleware('distributeur', ['except' => ['index']]);
        $this->middleware('admin', ['only' => ['destroy']]);
        $this->titreRepository = $titreRepository;
    }

    public function index()
    {
        $titres = Titre::all();
        $demandes = false;
        return view('titres.index', compact('titres', 'demandes'));
    }

    public function demandes(){
        $titres = Titre::where(['etat' => 'N', 'demande' => 1])->get();
        $demandes = true;
        return view('titres.index', compact('titres', 'demandes'));
    }

    public function create()
    {
        $type_titres = TypeTitre::pluck('libelle', 'id');
        $titres_prix = TypeTitre::pluck('prix', 'id');
        $zones = Zone::pluck('libelle', 'id');
        $vehicules = Vehicule::pluck('immatriculation', 'id');
        $type_vehicules = TypeVehicule::pluck('libelle', 'id');
        $structures = Structure::pluck('raison_sociale', 'id');
        $numero = intval(DB::table('titres')->max('numero'))+1;
        $justifs = pieceJustificatifs();
        $utilisateurs = User::all();
        $users = array();
        foreach ($utilisateurs as $user) {
            $users[$user->id] = $user->nom . ' ' . $user->prenom;
        }

        return view('titres.create', compact('numero', 'type_titres', 'titres_prix', 'users', 'zones', 'vehicules', 'type_vehicules', 'justifs', 'structures'));
    }

    public function store()
    {
        $inputs = request()->all();

        $numero = intval(DB::table('titres')->max('numero'))+1;

        $date = \DateTime::createFromFormat('d/m/Y', $inputs['date_delivrance']);
        $date_delivrance = $date->format('Y-m-d').' '.$inputs['heure_delivrance'];

        $type_titre = DB::table('type_titres')->where('id', $inputs['type_titre_id'])->first();

        $titre = new Titre();
        $titre->numero = $numero;
        $titre->duree = $inputs['duree'];
        $titre->date_delivrance = $date_delivrance;
        $titre->demande = 0;
        $titre->etat = 'V';
        $titre->cout = (intval($type_titre->prix)*intval($inputs['duree']))/24;
        $titre->piece = $inputs['piece'];
        $titre->zone_id = $inputs['zone_id'];
        $titre->type_titre_id = $inputs['type_titre_id'];
        $titre->agent_id = Auth::user()->id;
        $titre->usager_id = $inputs['usager_id'];
        $titre->created_at = date("Y-m-d H:i:s");
        $titre->updated_at = date("Y-m-d H:i:s");

        if($titre->save()){
            save_trace("Enregistrement du titre d'accès n° ".$titre->numero, LOG_INFORMATION);
            return response()->json(['response' => 'ok', 'last_insert_id' => $titre->id]);
        }

        return response()->json(['response' => 'error']);
    }

    public function show($id)
    {
        $titre = $this->titreRepository->getById($id);
        return view('titres.show', compact('titre'));
    }

    public function valider($id){

        $titre = $this->titreRepository->getById($id);
        $titre->etat = 'V';
        $titre->date_delivrance = date('Y-m-d H:i:s');
        $titre->agent_id = Auth::user()->id;

        if($titre->save()){
            save_trace("Validation de la demande du titre d'accès n° ".$titre->numero, LOG_INFORMATION);
            return redirect("demande/$id")->withOk('La demande du titre d\'accès n° : ' . $titre->numero . ' a été validée !');
        }
    }

    public function destroy($id)
    {
        $titre = $this->titreRepository->getById($id);
        $this->titreRepository->destroy($id);
        save_trace("Suppression du titre d'accès n° ".$titre->numero, LOG_SUPPRESSION);
        return back();
    }
}
