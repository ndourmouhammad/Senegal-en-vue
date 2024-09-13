<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
class UpdateSiteTouristiqueRequest extends FormRequest
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
            'libelle' => 'sometimes|string|max:255',
            'description' => 'sometimes|string',
            'contenu' => 'required|file|mimetypes:image/jpeg,image/png,video/mp4,video/quicktime|max:50480', // Permet des images ou vidéos
            'heure_ouverture' => 'sometimes|date_format:H:i',
            'heure_fermeture' => 'sometimes|date_format:H:i',
            'tarif_entree' => 'sometimes|integer|min:0',
            'region_id' => 'sometimes|exists:regions,id',
            'user_id' => 'sometimes|exists:users,id',
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
