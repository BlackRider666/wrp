<?php

namespace App\Http\Requests\Conference;

use Illuminate\Foundation\Http\FormRequest;

class CreateConferenceRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'title'     =>  'required|string|max:255',
            'date'      =>  'required|date',
            'city_id'   =>  'required|int|exists:cities,id',
            'file'      =>  'nullable|sometimes|file|mimes:pdf',
            'organizers' => 'required|array',
            'organizers.*' => 'required|int|exists:organizers,id',
        ];
    }
}
