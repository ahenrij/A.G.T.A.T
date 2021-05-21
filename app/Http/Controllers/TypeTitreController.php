<?php

namespace App\Http\Controllers;

use App\Repositories\TypeTitreRepository;
use Illuminate\Http\Request;
use App\TypeTitre;

use App\Http\Requests;
use Illuminate\Support\Facades\DB;

class TypeTitreController extends Controller
{
    protected $typetitre;
    protected $typeTitreRepository;

    public function __construct(TypeTitreRepository $typeTitreRepository)
    {
        $this->middleware('auth');
        $this->middleware('admin', ['except' => ['saveByAjax', 'getByIdToAjax', 'verifyTypeTitreExist']]);
        $this->middleware('ajax', ['only' => ['saveByAjax', 'getByIdToAjax', 'verifyTypeTitreExist']]);
        $this->typeTitreRepository = $typeTitreRepository;
    }

    public function index()
    {
        $typetitres = TypeTitre::all();
        return view('type_titres.index', compact('typetitres'));
    }

    public function store(Requests\TypeTitreCreateRequest $request)
    {
        $typetitre = $this->typeTitreRepository->store($request->all());
        save_trace("Enregistrement du type de titre " . $typetitre->libelle, LOG_INFORMATION);
        return redirect('typetitre')->withOk('Le type ' . $typetitre->libelle . ' a été créé.');
    }

    public function saveByAjax()
    {
        $inputs = request();
        $type = new TypeTitre();
        $type->code = $inputs['code'];
        $type->libelle = $inputs['libelle'];
        $type->duree = $inputs['duree'];
        $type->prix = $inputs['prix'];

        if ($type->save()) {
            save_trace("Enregistrement du type de titre " . $type->libelle, LOG_INFORMATION);
            return response()->json(['response' => 'ok']);
        } else {
            return response()->json(['response' => 'failure']);
        }
    }

    public function show($id)
    {
        $typetitre = $this->typeTitreRepository->getById($id);
        return view('type_titres.show', compact('typetitre'));
    }

    public function edit($id)
    {
        $typetitre = $this->typeTitreRepository->getById($id);
        return view('type_titres.edit', compact('typetitre'));
    }

    public function update(Requests\TypeTitreUpdateRequest $request, $id)
    {
        $this->typeTitreRepository->update($id, $request->all());
        save_trace("Modification du type de titre " . $this->typeTitreRepository->getById($id)->libelle, LOG_MODIFICATION);
        return redirect('typetitre')->withOk('Le type ' . $request->input('libelle') . ' a été modifié.');
    }

    public function destroy($id)
    {
        $typetitre = $this->typeTitreRepository->getById($id);

        if ((bool)($typetitre->titres()->first())) { // La type de titre est lié à plusieurs titres
            return redirect('typetitre')->withOk('Le type ' . $typetitre->libelle . ' est liée à des titres');
        }
        $this->typeTitreRepository->destroy($id);
        save_trace("Suppression du type de titre " . $typetitre->libelle, LOG_SUPPRESSION);
        return back();

    }

    public function getByIdToAjax($id)
    {
        return json_encode($this->typeTitreRepository->getById($id));
    }

    public function verifyTypeTitreExist()
    {
        $inputs = request();
        $type_titre = DB::table('type_titres')->where('duree', $inputs['duree'])->first();
        if (isset($type_titre->prix) && intval($type_titre->prix) > 0) {
            return response()->json(['exists' => 'ok']);
        }
        return response()->json(['exists' => 'no']);
    }
}
