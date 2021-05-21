<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class VehiculeUpdateRequest extends Request
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
        $id = $this->segment(2);
        return [
            'immatriculation' => 'bail|required|min:8|max:10|unique:vehicules,immatriculation,' . $id,
            'marque' => 'bail|required|min:4',
            'type_vehicule_id' => 'bail|required|exists:type_vehicules,id',
            'user_id' => 'bail|required|exists:users,id'
        ];
    }
}
