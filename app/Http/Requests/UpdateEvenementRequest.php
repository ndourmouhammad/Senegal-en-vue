<?php

namespace App\Http\Requests;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Foundation\Http\FormRequest;

class UpdateEvenementRequest extends FormRequest
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
            'nom' => 'sometimes|string|max:255',
            'description' => 'sometimes|string',
            'nombre_participant' => 'sometimes|integer|min:1',
            'date_debut' => 'sometimes|date|before_or_equal:date_fin',
            'date_fin' => 'sometimes|date|after_or_equal:date_debut',
            'prix' => 'sometimes|integer|min:0',
            'image' => 'sometimes|mimes:jpeg,jpg,png|max:2048',
            'category_id' => 'sometimes|integer|exists:categories,id',
            'site_touristique_id' => 'sometimes|integer|exists:site_touristiques,id',
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
