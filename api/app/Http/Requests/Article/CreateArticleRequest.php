<?php

namespace App\Http\Requests\Article;

use Illuminate\Foundation\Http\FormRequest;

class CreateArticleRequest extends FormRequest
{
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
            'title'      =>  'required|array',
            'title.*'     =>  'required|string|max:255',
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
            'desc'          => 'required|array',
            'desc.*'        => 'required|string',
            'full_text'     => 'required|array',
            'full_text.*'   => 'required|string',
            'file'          => 'required|file|mimes:pdf',
            'tags'          => 'array',
            'tags.*.id'     => 'required',
            'tags.*.name'   => 'required',
            'citations'          => 'array',
            'citations.*'        => 'int',
        ];
    }
}
