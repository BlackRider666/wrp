<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class StoreAuthorRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string
     */
    public function rules(): array
    {
        return [
            'first_name'    => 'required|array',
            'first_name.*'  => 'required|string|max:255',
            'second_name'   => 'required|array',
            'second_name.*' => 'required|string|max:255',
            'surname'       => 'required|array',
            'surname.*'     => 'required|string|max:255',
            'email'         => 'required|string|email|max:255|unique:users',
        ];
    }
}
