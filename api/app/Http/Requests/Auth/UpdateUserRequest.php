<?php

namespace App\Http\Requests\Auth;

use App\Enum\User\DegreeEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateUserRequest extends FormRequest
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
            'email'         => 'required|string|email|max:255|unique:users,email,'.request()->user()->getKey(),
            'phone'         => 'required|string|max:255',
            'desc'          => 'required|array',
            'desc.*'        => 'required|string',
            'degree'        => ['nullable','string', Rule::enum(DegreeEnum::class)],
            'position'      => 'nullable|string|max:255',
            'city_id'       => 'nullable|int|exists:cities,id',
            'organization_id' => 'nullable|int|exists:organization,id',
        ];
    }
}
