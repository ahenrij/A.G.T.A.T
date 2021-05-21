<?php

namespace App\Http\Controllers;

use App\Repositories\TypeUserRepository;
use Illuminate\Http\Request;
use App\TypeUser;

use App\Http\Requests;

class TypeUserController extends Controller
{
    protected $typeuser;
    protected $typeUserRepository;

    public function __construct(TypeUserRepository $typeUserRepository)
    {
        $this->middleware('auth');
        $this->middleware('admin');
        $this->typeUserRepository = $typeUserRepository;
    }

    public function index()
    {
        $typeusers = TypeUser::all();

        return view('type_users.index', compact('typeusers'));
    }

    public function store(Requests\TypeUserCreateRequest $request)
    {
        $typeuser = $this->typeUserRepository->store($request->all());
        save_trace("Enregistrement du type d'utilisateur ".$typeuser->libelle, LOG_INFORMATION);
        return redirect('typeuser')->withOk('Le type ' . $typeuser->libelle . ' a été créé.');
    }

    public function show($id)
    {
        $typeuser = $this->typeUserRepository->getById($id);
        return view('type_users.show', compact('typeuser'));
    }

    public function edit($id)
    {
        $typeuser = $this->typeUserRepository->getById($id);
        return view('type_users.edit', compact('typeuser'));
    }

    public function update(Requests\TypeUserUpdateRequest $request,$id)
    {
        $this->typeUserRepository->update($id, $request->all());
        save_trace("Modification du type d'utilisateur ".$this->typeUserRepository->getById($id)->libelle, LOG_MODIFICATION);
        return redirect('typeuser')->withOk('Le type ' . $request->input('libelle') . ' a été modifié.');
    }

    public function destroy($id)
    {
        $typeuser = $this->typeUserRepository->getById($id);
        if ((bool)($typeuser->users()->first())) { // La zone est liée à plusieurs utilisateurs
            return redirect('typeuser')->withOk('Le type ' . $typeuser->libelle . ' est lié à des titres');
        }
        $this->typeUserRepository->destroy($id);
        save_trace("Suppression du type d'utilisateur ".$typeuser->libelle, LOG_SUPPRESSION);
        return back();
    }
}
