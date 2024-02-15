<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SalleRequest extends FormRequest {
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array {
        return [
            'nom' => 'required|between:4,50',
            'adresse' => 'required|between:4,50',
            'code_postal' => 'required|between:4,50',
            'ville' => 'required|between:4,50',
        ];
    }

    public function messages() {
        return [
            'required' => 'Le champ :attribute est obligatoire',
            'between' => 'Le champ :attribute doit contenir entre :min et :max caractères'
        ];
    }
}
