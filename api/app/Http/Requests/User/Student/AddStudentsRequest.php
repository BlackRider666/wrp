<?php

namespace App\Http\Requests\User\Student;

use Illuminate\Foundation\Http\FormRequest;

class AddStudentsRequest extends FormRequest
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
            'students' => 'required|array',
            'students.*' => 'int|exists:users,id',
        ];
    }
}
