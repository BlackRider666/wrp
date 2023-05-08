<?php

namespace App\Http\Requests\User\SocialLink;

use Illuminate\Foundation\Http\FormRequest;

class StoreSocialLinkRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'url'   =>  'required|string|url|max:255',
            'type'  =>  'required|string|in:academia,facebook,google,instagram,linkedin,orcid,scopus,science'
        ];
    }
}
