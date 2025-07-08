<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
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
            'phone'         => 'required|string|max:255',
        ];
    }
}
