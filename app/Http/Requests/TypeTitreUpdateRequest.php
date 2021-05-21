<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class TypeTitreUpdateRequest extends Request
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
            'libelle' => 'bail|required|unique:type_titres,libelle,'.$id,
            'duree' => 'bail|required',
            'prix' => 'bail|required'
        ];
    }
}
