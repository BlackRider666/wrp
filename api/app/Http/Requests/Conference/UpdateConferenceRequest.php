<?php

namespace App\Http\Requests\Conference;

use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;

class UpdateConferenceRequest extends FormRequest
{
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

    protected function prepareForValidation()
    {
        $this->merge(['date' => Carbon::parse($this->date)]);
    }
}
