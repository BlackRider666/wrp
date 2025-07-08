<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class RegisterConfirmRequest extends RegisterRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return array_merge(parent::rules(),[
            'email'         => 'required|string|email|max:255',
            'password'      => 'required|string|max:255|confirmed',
        ]);
    }
}
