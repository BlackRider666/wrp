<?php

namespace App\Http\Requests\User\Work;

use Illuminate\Foundation\Http\FormRequest;

class CreateWorkRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return request()->user() !== null;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'start' =>  'required|date',
            'finish'    =>  'nullable|date|after:start',
            'position'  =>  'required|string|max:255',
            'organization' => 'required',
            'organization.id' => 'required',
            'structure_unit'    => 'required',
            'structure_unit.id' => 'required',
        ];
    }
}
