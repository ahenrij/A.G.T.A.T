<?php

namespace App\Http\Controllers;

use App\Repositories\TVehiculeRepository;
use Illuminate\Http\Request;
use App\TypeVehicule;

use App\Http\Requests;

class TypeVehiculeController extends Controller
{

    protected $TVehiculeRepository;

    public function __construct(TVehiculeRepository $TVehiculeRepository)
    {
        $this->middleware('auth');
        $this->middleware('admin');
        $this->TVehiculeRepository = $TVehiculeRepository;
    }

    public function index()
    {
        $typevehicules = TypeVehicule::all();
        $links = '';

        return view('type_vehicules.index', compact('typevehicules','links'));
    }

    public function store(Requests\TypeVehiculeCreateRequest $request)
    {
        $typevehicule = $this->TVehiculeRepository->store($request->all());
        save_trace("Enregistrement du type de véhicule ".$typevehicule->libelle, LOG_INFORMATION);
        return redirect('typevehicule')->withOk('Le type ' . $typevehicule->libelle . ' a été créé.');
    }

    public function show($id)
    {
        $typevehicule = $this->TVehiculeRepository->getById($id);
        return view('type_vehicules.show', compact('typevehicule'));
    }

    public function edit($id)
    {
        $typevehicule = $this->TVehiculeRepository->getById($id);
        return view('type_vehicules.edit',compact('typevehicule'));
    }

    public function update(Requests\TypeVehiculeUpdateRequest $request, $id)
    {
        $this->TVehiculeRepository->update($id,$request->all());
        save_trace("Modification du type de véhicule ".$this->TVehiculeRepository->getById($id)->libelle, LOG_MODIFICATION);
        return redirect('typevehicule')->withOk('Le type ' . $request->input('libelle') . ' a été modifié.');
    }

    public function destroy($id)
    {
        $typevehicule = $this->TVehiculeRepository->getById($id);

        if ((bool)($typevehicule->vehicules()->first())) { // La zone est liée à plusieurs vehicules
            return redirect('typevehicule')->withOk('Le type ' . $typevehicule->libelle . ' est liée à des vehicules');
        }
        $this->TVehiculeRepository->destroy($id);
        save_trace("Suppression du type de véhicule ".$typevehicule->libelle, LOG_SUPPRESSION);
        return back();
    }
}
