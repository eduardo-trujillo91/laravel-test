<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CustomersPostRequest extends FormRequest
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
            'uuid' => 'required|uuid|unique:customers',
            'firstName' => 'required|string',
            'lastName' => 'required|string',
            'dateOfBirth' => 'required|date',
            'status' => ['required', Rule::in('new', 'pending', 'in review', 'approved', 'inactive', 'deleted')]
        ];
    }

    public function messages()
    {
        return [
            'uuid.required' => 'El UUID es obligatorio.',
            'uuid.uuid' => 'El UUID no es valido.',
            'firstName.required' => 'El Nombre es obligatorio',
            'lastName.required' => 'Los Apellidos es obligatorio',
            'dateOfBirth.required' => 'La Fecha de Nacimiento es obligatoria',
            'dateOfBirth.date' => 'La Fecha de Nacimiento es un campo de fecha',
            'status.required' => 'El Estado es obligatorio',
        ];
    }
}
