<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class UserCreateRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            //
            'nom' => 'required|regex:/^[a-zA-Z \' , . -]*$/|min:3|max:255',
            'prenom' => 'required|regex:/^[a-zA-Z \' , . -]*$/|min:3|max:400',
            'fonction' => 'required|string|min:4|max:400',
            'telephone' => 'numeric|required|min:8|unique:users',
            'login' => 'required|string|regex:/^[a-zA-Z\.0-9]*$/|min:3|max:255|unique:users',
            'password' => 'required|min:6|max:20|confirmed',
            'profil' => 'image',
            'structure_id' => 'required|exists:structures,id',
            'type_user_id' => 'required|exists:type_users,id',
            'groupe_id' => 'required|exists:groupes,id'
        ];
    }
}
