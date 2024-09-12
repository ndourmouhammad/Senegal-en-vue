<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class UpdateUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'sometimes|string|max:255',
            'email' => 'sometimes|string|email|max:255|unique:users',
            'password' => 'sometimes|string|min:8|confirmed',
            'photo_profil' => 'sometimes|mimes:jpeg,jpg,png,gif|max:4048',
            'adresse' => 'sometimes|string|max:255',
            'telephone' => 'sometimes|string|max:20|min:9|unique:users',
            'genre' => 'sometimes|in:Homme,Femme',
            'date_naissance' => 'sometimes|date|date_format:Y-m-d',
            'langues' => 'nullable|string',
            'numero_carte_guide' => 'nullable',
            'carte_guide' => 'nullable|mimes:jpeg,jpg,png,gif|max:4048',
            'note' => 'nullable|integer|min:0|max:10',
        ];
    }

    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'success'   => false,
            'errors'      => $validator->errors()
        ], 422));
    }
}
