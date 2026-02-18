<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
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
            'title' => 'sometimes|required|string|max:255',
            'developer' => 'sometimes|required|string|max:255',
            'distribution' => 'sometimes|required|string|max:255',
            'description' => 'sometimes|required',
            'game_mode' => 'sometimes|required|string|max:255',
            'classification' => 'sometimes|required|string|max:255',
            'genre' => 'sometimes|required|string|max:255',
            'platform' => 'sometimes|required|string|max:255',
            'release_year' => 'sometimes|required|digits:4|integer',
            'cover_image' => 'nullable|string',
        ];
    }
}
