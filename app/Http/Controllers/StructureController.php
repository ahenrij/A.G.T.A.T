<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\StructureRepository;
use App\Structure;

use App\Http\Requests;

class StructureController extends Controller
{
    protected $structure;
    protected $structureRepository;

    public function __construct(StructureRepository $structureRepository)
    {
        $this->middleware('auth');
        $this->middleware('admin', ['except' => ['saveByAjax']]);
        $this->middleware('ajax', ['only' => ['saveByAjax']]);
        $this->structureRepository = $structureRepository;
    }

    public function index()
    {
        $structures = Structure::all();
        return view('structures.index', compact('structures'));
    }


    public function store(Requests\StructureCreateRequest $request)
    {
        $structure = $this->structureRepository->store($request->all());
        save_trace("Enregistrement de la structure " . $structure->raison_sociale, LOG_INFORMATION);
        return redirect('structure')->withOk('La structure ' . $structure->raison_sociale . ' a été créée.');
    }

    public function saveByAjax()
    {
        $inputs = request();
        $structure = new Structure();
        $structure->raison_sociale = $inputs['raison_sociale'];
        $structure->contact = $inputs['contact'];
        $structure->adresse = $inputs['adresse'];

        if ($structure->save()) {
            save_trace("Enregistrement de la structure " . $structure->raison_sociale, LOG_INFORMATION);
            return response()->json(['response' => 'ok']);
        } else {
            return response()->json(['response' => 'failure']);
        }
    }

    public function show($id)
    {
        $structure = $this->structureRepository->getById($id);
        return view('structures.show', compact('structure'));
    }

    public function edit($id)
    {
        $structure = $this->structureRepository->getById($id);
        return view('structures.edit', compact('structure'));
    }

    public function update(Requests\StructureUpdateRequest $request, $id)
    {
        $this->structureRepository->update($id, $request->all());
        save_trace("Modification de la structure " . $this->structureRepository->getById($id)->raison_sociale, LOG_MODIFICATION);
        return redirect('structure')->withOk('La structure ' . $request->input('raison_sociale') . ' a été modifiée');
    }

    public function destroy($id)
    {
        $structure = $this->structureRepository->getById($id);

        if ((bool)($structure->users()->first())) {  // La structure est liée à plusieurs utilisateurs
            return redirect('structure')->withOk('Des utilisateurs appartiennent à la structure ' . $structure->raison_sociale);
        }
        $this->structureRepository->destroy($id);
        save_trace("Suppression de la structure " . $structure->raison_sociale, LOG_SUPPRESSION);
        return back();

    }
}
