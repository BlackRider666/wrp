<?php

namespace App\Http\Requests\User\Grant;

use Illuminate\Foundation\Http\FormRequest;

class SearchGrantRequest extends FormRequest
{
    /**
     * @return string[]
     */
    public function rules(): array
    {
        return [
            'user_id' => 'nullable|integer|exists:users,id',
            'perPage' => 'nullable|integer|min:1|max:100',
            'page' => 'nullable|integer|min:1',
        ];
    }

    /**
     * @return void
     */
    public function passedValidation(): void
    {
        if(!$this->user_id) {
            $this->merge([
                'user_id' => $this->user()->getKey()
            ]);
        }
    }
}
