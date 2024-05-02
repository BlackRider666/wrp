<?php

namespace App\Http\Requests\Article;

use Illuminate\Foundation\Http\FormRequest;

class SearchArticleRequest extends FormRequest
{
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
            'sortBy'    =>  'string|max:255',
            'sortDesc'  =>  'boolean',
            'user_id'   =>  'int',
            'title'     =>  'string|max:255',
            'country_id'    =>  'int',
            'city_id'       =>  'int',
            'nonApproved'   =>  'boolean',
            'category_name' => 'nullable|string',
            'conference_id' => 'nullable|int',
        ];
    }
}
