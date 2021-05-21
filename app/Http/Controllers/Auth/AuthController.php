<?php

namespace App\Http\Controllers\Auth;

use App\User;
use Illuminate\Support\Facades\Log;
use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Registration & Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users, as well as the
    | authentication of existing users. By default, this controller uses
    | a simple trait to add these behaviors. Why don't you explore it?
    |
    */

    use AuthenticatesAndRegistersUsers, ThrottlesLogins;

    /**
     * Where to redirect users after login / registration.
     *
     * @var string
     */
    protected $redirectTo = '/';

    protected $username = 'login';

    /**
     * Create a new authentication controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware($this->guestMiddleware(), ['except' => 'logout']);
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'nom' => 'required|max:255',
            'prenom' => 'required|max:400',
            'fonction' => 'required|max:400',
            'telephone' => 'required|max:400',
            'login' => 'required|max:255|unique:users',
            'password' => 'required|min:6|confirmed',
            'profil' => 'image',
            'structure_id' => 'required|exists:structures,id',
            'type_user_id' => 'required|exists:type_users,id',
            'groupe_id' => 'required|exists:groupes,id',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array $data
     * @return User
     */
    protected function create(array $data)
    {
        return User::create([
            'nom' => $data['nom'],
            'prenom' => $data['prenom'],
            'fonction' => $data['fonction'],
            'telephone' => $data['telephone'],
            'login' => $data['login'],
            'password' => $data['password'],
            'profil' => $data['profil'],
            'structure_id' => $data['structure_id'],
            'type_user_id' => $data['type_user_id'],
            'groupe_id' => $data['groupe_id'],
        ]);
    }

}
