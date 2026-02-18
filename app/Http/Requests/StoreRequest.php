<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
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
            //
            'title' => 'required|string|max:255',
            'developer' => 'required|string|max:255',
            'distribution' => 'required|string|max:255',
            'description' => 'required',
            'game_mode' => 'required|string|max:255',
            'classification' => 'required|string|max:255',
            'genre' => 'required|string|max:255',
            'platform' => 'required|string|max:255',
            'release_year' => 'required|digits:4|integer',
            'cover_image' => 'nullable|string',
        ];
    }

    public function messages(): array
{
    return [
        'title.required' => 'El título es obligatorio.',
        'title.string' => 'El título debe ser una cadena de texto.',
        'title.max' => 'El título no puede tener más de 255 caracteres.',

        'developer.required' => 'El desarrollador es obligatorio.',
        'developer.string' => 'El desarrollador debe ser una cadena de texto.',
        'developer.max' => 'El desarrollador no puede tener más de 255 caracteres.',

        'distribution.required' => 'La distribución es obligatoria.',
        'distribution.string' => 'La distribución debe ser una cadena de texto.',
        'distribution.max' => 'La distribución no puede tener más de 255 caracteres.',

        'description.required' => 'La descripción es obligatoria.',

        'game_mode.required' => 'El modo de juego es obligatorio.',
        'game_mode.string' => 'El modo de juego debe ser una cadena de texto.',
        'game_mode.max' => 'El modo de juego no puede tener más de 255 caracteres.',

        'classification.required' => 'La clasificación es obligatoria.',
        'classification.string' => 'La clasificación debe ser una cadena de texto.',
        'classification.max' => 'La clasificación no puede tener más de 255 caracteres.',

        'genre.required' => 'El género es obligatorio.',
        'genre.string' => 'El género debe ser una cadena de texto.',
        'genre.max' => 'El género no puede tener más de 255 caracteres.',

        'platform.required' => 'La plataforma es obligatoria.',
        'platform.string' => 'La plataforma debe ser una cadena de texto.',
        'platform.max' => 'La plataforma no puede tener más de 255 caracteres.',

        'release_year.required' => 'El año de lanzamiento es obligatorio.',
        'release_year.digits' => 'El año de lanzamiento debe tener exactamente 4 dígitos.',
        'release_year.integer' => 'El año de lanzamiento debe ser un número entero.',

        'cover_image.string' => 'La imagen de portada debe ser una cadena de texto.',
    ];
}

}
