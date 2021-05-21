<?php

namespace App\Http\Controllers;

use App\Repositories\TitreRepository;
use App\Titre;
use App\TypeTitre;
use App\Zone;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DemandeController extends Controller
{

    protected $titreRepository;

    public function __construct(TitreRepository $titreRepository)
    {
        $this->middleware('auth');
        $this->middleware('usager', ['except' => ['show']]);
        $this->middleware('distributeur', ['only' => ['show']]);
        $this->titreRepository = $titreRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $demandes = Titre::where(['demande' => 1, 'usager_id' => Auth::user()->id])->get();
        return view('titres.demandes.index', compact('demandes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(DB::table('vehicules')->where('user_id',Auth::user()->id)->first()){ //Si c'est un chauffeur
            $type_titres = TypeTitre::pluck('libelle', 'id');
        }else{
            $type_titres = TypeTitre::where('code', 'BT')->pluck('libelle', 'id');
        }

        $zones = Zone::pluck('libelle', 'id');
        $numero = intval(DB::table('titres')->max('numero'))+1;
        $justifs = pieceJustificatifs();

        return view('titres.demandes.create', compact('numero', 'type_titres', 'zones', 'justifs'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $inputs = $request->all();

        $numero = intval(DB::table('titres')->max('numero'))+1;
        $type_titre = DB::table('type_titres')->where('id', $inputs['type_titre_id'])->first();
        $duree = isset($inputs['duree']) ? $inputs['duree'] : $type_titre->duree;

        $titre = new Titre();
        $titre->numero = $numero;
        $titre->duree = $duree;
        $titre->date_delivrance = date("Y-m-d H:i:s");
        $titre->demande = 1;
        $titre->etat = 'N';
        $titre->cout = (intval($type_titre->prix)*intval($duree))/24;
        $titre->piece = $inputs['piece'];
        $titre->zone_id = $inputs['zone_id'];
        $titre->type_titre_id = $inputs['type_titre_id'];
        $titre->agent_id = getNoAgentId();
        $titre->usager_id = Auth::user()->id;
        $titre->created_at = date("Y-m-d H:i:s");
        $titre->updated_at = date("Y-m-d H:i:s");

        if($titre->save()){
            save_trace("Enregistrement de la demande du titre n° ".$titre->numero, LOG_INFORMATION);
            return redirect('demande')->withOk('Votre demande a été correctement enregistrée !');
        }

        return redirect('demande/create')->withEr('Désolé ! Votre demande n\'a pas pu être enregistré.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $titre = $this->titreRepository->getById($id);
        return view('titres.demandes.show',  compact('titre'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
