<?php

namespace App\Http\Requests\Locale;

use Illuminate\Foundation\Http\FormRequest;

class StoreLocaleRequest extends FormRequest
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
            'iso_code' => 'required|string|max:255',
            'key'      => 'required|string|max:255',
            'value'    => 'required|string|max:255',
        ];
    }
}
