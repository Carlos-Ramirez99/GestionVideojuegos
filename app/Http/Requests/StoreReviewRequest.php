<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreReviewRequest extends FormRequest
{
    public function authorize(): bool
    {
        //Solo usuarios autenticados pueden crear reseñas
        return auth()->check();
    }

    public function rules(): array
    {
        return [
            'content' => ['required', 'string', 'min:10', 'max:1000'],
            'title' => ['nullable', 'string', 'max:100'],
        ];
    }

    public function messages(): array
    {
        return [
            'content.required' => 'El contenido de la reseña es obligatorio.',
            'content.string' => 'El contenido de la reseña debe ser texto.',
            'content.min' => 'El contenido de la reseña debe tener al menos 10 caracteres.',
            'content.max' => 'El contenido de la reseña no puede superar los 1000 caracteres.',

            'title.nullable' => 'El título puede estar vacío.',
            'title.string' => 'El título debe ser texto.',
            'title.max' => 'El título no puede superar los 100 caracteres.',
        ];
    }
}
