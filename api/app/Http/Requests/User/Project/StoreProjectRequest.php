<?php

namespace App\Http\Requests\User\Project;

use Illuminate\Foundation\Http\FormRequest;

class StoreProjectRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'name'      =>  'required|array',
            'name.*'     =>  'required|string|max:255',
        ];
    }
}
