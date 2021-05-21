<?php

namespace App\Repositories;

use App\User;

class UserRepository
{

    protected $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    private function save(User $user, Array $inputs)
    {
        $user->nom = $inputs['nom'];
        $user->prenom = $inputs['prenom'];
        $user->fonction = $inputs['fonction'];
        $user->telephone = $inputs['telephone'];
        $user->login = $inputs['login'];
        if(!empty($inputs['image_profil'])){
            $user->profil = $inputs['image_profil'];
        }
        $user->structure_id = $inputs['structure_id'];
        $user->type_user_id = $inputs['type_user_id'];
        $user->groupe_id = $inputs['groupe_id'];

        $user->save();
    }

    public function getPaginate($n)
    {
        return $this->user->paginate($n);
    }

    public function store(Array $inputs)
    {
        $user = new $this->user;
        $user->password = bcrypt($inputs['password']);

        $this->save($user, $inputs);
        return $user;
    }

    public function getById($id)
    {
        return $this->user->findOrFail($id);
    }

    public function update($id, Array $inputs)
    {
        $user = $this->getById($id);
        if(isset($inputs['password']) && !empty($inputs['password'])){
            $user->password = bcrypt($inputs['password']);
        }
        $this->save($user, $inputs);
    }

    public function destroy($id)
    {
        $this->getById($id)->delete();
    }

}

?>