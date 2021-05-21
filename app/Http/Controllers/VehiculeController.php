<?php

namespace App\Http\Controllers;

use App\TypeVehicule;
use App\User;
use App\Vehicule;
use Illuminate\Http\Request;
use App\Repositories\VehiculeRepository;

use App\Http\Requests;
use Illuminate\Support\Facades\DB;

class VehiculeController extends Controller
{

    protected $vehicule;
    protected $vehiculeRepository;

    public function __construct(VehiculeRepository $vehiculeRepository)
    {
        $this->middleware('auth');
        $this->middleware('admin', ['except' => ['getByIdToAjax', 'saveByAjax']]);
        $this->middleware('ajax', ['only' => ['getByIdToAjax', 'saveByAjax']]);
        $this->vehiculeRepository = $vehiculeRepository;
    }

    public function index()
    {
        $vehicules = Vehicule::all();
        $type_vehicules = TypeVehicule::pluck('libelle', 'id');
        $utilisateurs = User::all();
        $users = array();
        foreach ($utilisateurs as $user) {
            $users[$user->id] = $user->prenom . ' ' . $user->nom;
        }

        return view('vehicules.index', compact('vehicules', 'type_vehicules', 'users'));
    }

    public function store(Requests\VehiculeCreateRequest $request)
    {
        $vehicule = $this->vehiculeRepository->store($request->all());
        save_trace("Enregistrement du véhicule immatriculé : ".$vehicule->immatriculation, LOG_INFORMATION);
        return redirect('vehicule')->withOk('Le véhicule d\'immatriculation : ' . $vehicule->immatriculation . ' a été créé.');
    }

    public function saveByAjax()
    {
        $inputs = request();
        $vehicule = new Vehicule();
        $vehicule->immatriculation = $inputs['immatriculation'];
        $vehicule->marque = $inputs['marque'];
        $vehicule->type_vehicule_id = $inputs['type_vehicule_id'];
        $vehicule->user_id = $inputs['user_id'];

        if ($vehicule->save()) {
            save_trace("Enregistrement du véhicule immatriculé : ".$vehicule->immatriculation, LOG_INFORMATION);
            return response()->json(['response' => 'ok']);
        } else {
            return response()->json(['response' => 'failure']);
        }
    }

    public function show($id)
    {
        $vehicule = $this->vehiculeRepository->getById($id);
        return view('vehicules.show', compact('vehicule'));
    }

    public function edit($id)
    {
        $vehicule = $this->vehiculeRepository->getById($id);

        $type_vehicules = TypeVehicule::pluck('libelle', 'id');
        $utilisateurs = User::all();
        $users = array();
        foreach ($utilisateurs as $user) {
            $users[$user->id] = $user->prenom . ' ' . $user->nom;
        }

        return view('vehicules.edit', compact('vehicule', 'type_vehicules', 'users'));
    }

    public function update(Requests\VehiculeUpdateRequest $request, $id)
    {
        $this->vehiculeRepository->update($id, $request->all());
        save_trace("Modification du véhicule immatriculé : " . $request->input('immatriculation'), LOG_MODIFICATION);
        return redirect('vehicule')->withOk('Le véhicule d\'immatriculation : ' . $request->input('immatriculation') . ' a été modifié.');
    }

    public function destroy($id)
    {
        $vehicule = $this->vehiculeRepository->getById($id);

        $titres = DB::table('vehicules')
            ->join('titres', 'vehicules.user_id', '=', 'titres.usager_id')
            ->where('vehicules.id', $id)
            ->select('titres.*')
            ->get();

        if (!empty($titres)) { //Des titres concernent le véhicule
            return redirect('vehicule')->withOk('Suppression impossible : Le véhicule ' . $vehicule->immatriculation . ' est lié à des titres');
        }

        $this->vehiculeRepository->destroy($id);
        save_trace("Suppression du véhicule immatriculé : " . $vehicule->immatriculation, LOG_SUPPRESSION);
        return back();
    }

    public function getByIdToAjax($id)
    {
        $vehicule = DB::table('vehicules')->where('id', $id)->first();
        $user = DB::table('users')->where('id', $vehicule->user_id)->first();
        $structure = DB::table('structures')->where('id', $user->structure_id)->first();

        $vehicule->user = $user->nom . ' ' . $user->prenom;
        $vehicule->fonction = $user->fonction;
        $vehicule->telephone = $user->telephone;
        $vehicule->structure = $structure->raison_sociale;

        if (!empty($vehicule->id)) {
            return json_encode($vehicule);
        } else {
            return false;
        }
    }

}
