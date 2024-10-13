<?php

namespace App\Http\Requests;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Foundation\Http\FormRequest;

class StoreExcursionRequest extends FormRequest
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
            'libelle' => 'required|string|max:255',
            'description' => 'required',
            'contenu' => 'required|file|mimetypes:image/jpeg,image/png,video/mp4,video/quicktime|max:50480',
            'image' => 'nullable|mimes:jpeg,jpg,png,gif|max:5048',
            'date_debut' => 'required|date|before_or_equal:date_fin|after_or_equal:today',
            'date_fin' => 'required|date|after_or_equal:date_debut',
            'tarif_entree' => 'required|integer|min:0',
            'nombre_participants' => 'required|integer|min:0',
            'site_touristique_id' => 'required|exists:site_touristiques,id',
        ];
    }

    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'success'   => false,
            'message'   => 'Validation errors',
            'data'      => $validator->errors()
        ]));
    }
}
