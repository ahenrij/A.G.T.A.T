<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class StructureUpdateRequest extends Request
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
            'raison_sociale' => 'bail|required',
            'contact' => 'bail|required|max:20|unique:structures,raison_sociale,'.$id,
            'adresse' => 'bail|required'
        ];
    }
}
