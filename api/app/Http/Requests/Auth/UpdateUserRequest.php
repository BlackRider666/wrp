<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
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
            'first_name' => 'required|string|max:255',
            'second_name'   => 'required|string|max:255',
            'surname'       => 'required|string|max:255',
            'email'         => 'required|string|email|max:255|unique:users,email,'.request()->user()->getKey(),
            'phone'         => 'required|string|max:255',
            'desc'          => 'required|string',
            'degree'        => 'nullable|string|max:255',
            'position'      => 'nullable|string|max:255',
            'city_id'       => 'nullable|int|exists:cities,id',
            'organization_id' => 'nullable|int|exists:organization,id',
        ];
    }
}
