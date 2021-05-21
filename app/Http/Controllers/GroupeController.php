<?php

namespace App\Http\Controllers;

use App\Repositories\GroupeRepository;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Groupe;

class GroupeController extends Controller
{

    protected $groupe;
    protected $groupeRepository;

    public function __construct(GroupeRepository $groupeRepository)
    {
        $this->middleware('auth');
        $this->middleware('admin');
        $this->groupeRepository = $groupeRepository;
    }

    public function index()
    {
        $groupes = Groupe::all();
        return view('groupes.index', compact('groupes','links'));
    }

    public function store(Requests\GroupeCreateRequest $request)
    {
        $groupe = $this->groupeRepository->store($request->all());
        save_trace("Enregistrement du groupe ".$groupe->libelle, LOG_INFORMATION);
        return redirect('groupe')->withOk('Le groupe ' . $groupe->libelle . ' a été créé.');
    }

    public function show($id)
    {
        $groupe = $this->groupeRepository->getById($id);
        return view('groupes.show', compact('groupe'));
    }

    public function edit($id)
    {
        $groupe = $this->groupeRepository->getById($id);
        return view('groupes.edit', compact('groupe'));
    }

    public function update(Requests\GroupeUpdateRequest $request,$id)
    {
        $this->groupeRepository->update($id, $request->all());
        save_trace("Modification du groupe ".$this->groupeRepository->getById($id)->libelle, LOG_MODIFICATION);
        return redirect('groupe')->withOk('Le groupe ' . $request->input('libelle') . ' a été modifié.');
    }

    public function destroy($id)
    {
        $groupe = $this->groupeRepository->getById($id);

        if ((bool)($groupe->users()->first())) { // La zone est liée à plusieurs titres
            return redirect('groupe')->withOk('Suppression impossible : Des utilisateurs appartiennent au groupe ' . $groupe->libelle);
        }

        $this->groupeRepository->destroy($id);
        save_trace("Suppression du groupe ".$groupe->libelle, LOG_SUPPRESSION);
        return back();
    }
}
