<?php

namespace App\Http\Requests\Organization\Unit;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateUnitRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'name'              =>  'required|string|max:255',
            'parent_id'         =>  'nullable|int|exists:structural_units,id',
            'type'              =>  ['required',Rule::in(['esi','faculty','cathedra','sri','institute','unit','section','department'])],
        ];
    }
}
