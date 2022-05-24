<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CollectionRequest extends FormRequest
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
        $rules = [
            'description' => 'required|string',
            'products' => 'array',
            'products.*' => 'integer',
        ];
        
        $rules['name'] = ($this->request->has('id') && $this->request->get('id')==null) ? 'required|string|min:1|unique:collections' : 'string|min:1|unique:collections,id,'.$this->request->get('id');
        return $rules;
    }
}
