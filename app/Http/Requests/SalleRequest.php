<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SalleRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules() {
        return [
            'nom' => "required|string|between:5,50",
            'prenom' => "required|string|between:5,50",
            'age' => "numeric|between:18,65"
        ];
    }
    public function messages(): array {
    return [
        'required' => 'Le champ :attribute est obligatoire',
        'between' => 'Le champ :attribute doit contenir entre :min et :max caractères.',
        'age.between' => 'L\'age doit avoir une valeur comprise entre :min et :max.',
        ];
    }


}
