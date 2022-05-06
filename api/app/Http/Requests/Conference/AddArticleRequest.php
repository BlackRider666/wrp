<?php

namespace App\Http\Requests\Conference;

use Illuminate\Foundation\Http\FormRequest;

class AddArticleRequest extends FormRequest
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
            'country_id' => 'required|int|exists:countries,id',
            'city_id'    => 'required|int|exists:cities,id',
            'title'      =>  'required|string|max:255',
            'category_id' => 'required|int|exists:categories,id',
            'year'        => 'required|date_format:Y',
            'authors'     => 'required|array',
            'authors.*'   => 'required|int|exists:users,id',
            'journal'     => 'nullable|string|max:255',
            'part'        => 'nullable|string|max:255',
            'number'      => 'nullable|string|max:255',
            'pages'       => 'nullable|string|max:255',
            'publisher'   => 'nullable|string|max:255',
            'patent_number' => 'nullable|string|max:255',
            'app_number'    => 'nullable|string|max:255',
        ];
    }
}
