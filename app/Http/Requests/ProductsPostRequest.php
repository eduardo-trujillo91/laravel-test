<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProductsPostRequest extends FormRequest
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
            'issn' => 'required|integer|unique:products',
            'name' => 'required|string',
            'customer' => 'required|integer',
            'status' => ['required', Rule::in('new', 'pending', 'in review', 'approved', 'inactive', 'deleted')]
        ];
    }

    public function messages()
    {
        return [
            'issn.required' => 'El ISSN es obligatorio.',
            'issn.integer' => 'El ISSN no es valido.',
            'name.required' => 'El Nombre es obligatorio',
            'customer.required' => 'El Cliente es obligatoria',
            'customer.integer' => 'EL id del Cliente es un entero',
            'status.required' => 'El Estado es obligatorio',
        ];
    }
}
