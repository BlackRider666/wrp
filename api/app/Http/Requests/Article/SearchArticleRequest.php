<?php

namespace App\Http\Requests\Article;

use Illuminate\Foundation\Http\FormRequest;

class SearchArticleRequest extends FormRequest
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
            'q' =>  'string|max:255',
            'forSelect' =>  'boolean',
            'perPage'   =>  'int',
            'page'      =>  'int',
            'sortBy'    =>  'string|max:255g',
            'sortDesc'  =>  'boolean',
            'user_id'   =>  'int',
            'title'     =>  'string|max:255',
            'country_id'    =>  'int',
            'city_id'       =>  'int',
            'nonApproved'   =>  'boolean',
            'category_name' => 'nullable|string',
        ];
    }
}
