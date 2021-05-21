<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserUpdateRequest;

use App\Http\Requests\UserCreateRequest;

use App\Repositories\UserRepository;


use App\Groupe;
use App\Structure;
use App\TypeUser;
use App\User;
use Illuminate\Support\Facades\DB;
use \Intervention\Image\Facades\Image;

class UserController extends Controller
{

    protected $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->middleware('auth');
        $this->middleware('admin', ['except' => ['getByIdToAjax', 'checkPhoneNumberExist', 'saveBeneficiaireByAjax']]);
        $this->middleware('ajax', ['only' => ['getByIdToAjax', 'checkPhoneNumberExist', 'saveBeneficiaireByAjax']]);
        $this->userRepository = $userRepository;
    }

    public function index()
    {
        $users = User::all();
        return view('users.index', compact('users', 'links'));
    }

    public function create()
    {
        $structures = Structure::pluck('raison_sociale', 'id');
        $type_users = TypeUser::pluck('libelle', 'id');
        $groupes = Groupe::pluck('libelle', 'id');

        return view('users.create', compact('structures', 'type_users', 'groupes'));
    }

    public function store(UserCreateRequest $request)
    {
        $filename = '';
        if ($request->hasFile('profil')) {
            $image = $request->file('profil');
            $filename = time() . '.' . $image->getClientOriginalExtension();
            $path = public_path('img/profils/' . $filename);
            Image::make($image->getRealPath())->resize(300, 300)->save($path);
        }

        $inputs = array_merge($request->all(), ['image_profil' => $filename]);
        $user = $this->userRepository->store($inputs);

        save_trace("Enregistrement de l'utilisateur " . $user->prenom . ' ' . $user->nom, LOG_INFORMATION);
        return redirect('user')->withOk("L'utilisateur " . $user->prenom . ' ' . $user->nom . " a été créé.");
    }

    public function saveBeneficiaireByAjax()
    {
        $inputs = request();
        $user = new User();
        $user->nom = $inputs['nom'];
        $user->prenom = $inputs['prenom'];
        $user->fonction = $inputs['fonction'];
        $user->structure_id = $inputs['structure_id'];
        $user->adresse = $inputs['adresse'];
        $user->telephone = $inputs['telephone'];
        $user->login = $inputs['telephone'];
        $user->password = bcrypt($inputs['telephone']);
        $user->profil = 'man-' . rand(1, 10) . '.png';
        $user->type_user_id = getIdTypeUser(USAGER_LABEL);
        $user->groupe_id = getNoGroupId();

        if ($user->save()) {
            save_trace("Enregistrement de l'usager " . $user->prenom . ' ' . $user->nom, LOG_INFORMATION);
            return response()->json(['response' => 'ok']);
        } else {
            return response()->json(['response' => 'failure']);
        }
    }

    public function show($id)
    {
        $user = $this->userRepository->getById($id);
        return view('users.show', compact('user'));
    }

    public function edit($id)
    {
        $user = $this->userRepository->getById($id);
        $structures = Structure::pluck('raison_sociale', 'id');
        $type_users = TypeUser::pluck('libelle', 'id');
        $groupes = Groupe::pluck('libelle', 'id');

        return view('users.edit', compact('user', 'structures', 'type_users', 'groupes'));
    }

    public function update(UserUpdateRequest $request, $id)
    {
        $filename = '';
        if ($request->hasFile('profil')) {
            $image = $request->file('profil');
            $filename = time() . '.' . $image->getClientOriginalExtension();
            $path = public_path('img/profils/' . $filename);
            Image::make($image->getRealPath())->resize(300, 300)->save($path);
        }

        $this->userRepository->update($id, array_merge($request->all(), ['image_profil' => $filename]));

        $name = $request->input('prenom') . ' ' . $request->input('nom');

        save_trace("Modification des informations de l'utilisateur " . $name, LOG_MODIFICATION);
        return redirect('user')->withOk("L'utilisateur " . $name . " a été modifié.");
    }

    public function destroy($id)
    {
        $user = $this->userRepository->getById($id);
        $this->userRepository->destroy($id);

        save_trace("Suppression de l'utilisateur ".$user, LOG_SUPPRESSION);
        return redirect()->back();
    }

    public function getByIdToAjax($id)
    {
        $user = DB::table('users')->where('id', $id)->first();

        $structure = DB::table('structures')->where('id', $user->structure_id)->first();
        $vehicule = DB::table('vehicules')->where('user_id', $user->id)->first();

        $user->structure = $structure->raison_sociale;
        if ($vehicule != null) $user->immatriculation = $vehicule->immatriculation;
        else $user->immatriculation = 0;

        if (!empty($user->id)) {
            return json_encode($user);
        }
        return false;
    }

    public function checkPhoneNumberExist()
    {
        $inputs = request();
        $user = DB::table('users')->where('telephone', 'like', $inputs['telephone'])->first();

        if (isset($user->id) && intval($user->id) > 0) {
            return response()->json(['exists' => 'ok']);
        }
        return response()->json(['exists' => 'no', 'input' => $inputs['telephone']]);
    }
}
