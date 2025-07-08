<?php

namespace App\Http\Requests\User\Grant;

use Illuminate\Foundation\Http\FormRequest;

class StoreGrantRequest extends FormRequest
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
