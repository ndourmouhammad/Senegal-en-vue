<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class RegisterUserRequest extends FormRequest
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
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'photo_profil' => 'required|mimes:jpeg,jpg,png,gif|max:4048',
            'adresse' => 'required|string|max:255',
            'telephone' => 'required|string|max:20|min:9|unique:users',
            'role' => 'required|string|in:touriste,guide',
            'genre' => 'required|in:Homme,Femme',
            'date_naissance' => 'required|date|date_format:Y-m-d',
            'langues' => 'nullable|string',
            'numero_carte_guide' => 'nullable',
            'carte_guide' => 'nullable',
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
