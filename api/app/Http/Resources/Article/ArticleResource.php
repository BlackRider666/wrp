<?php

namespace App\Http\Resources\Article;

use App\Http\Resources\Tag\TagResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ArticleResource extends JsonResource
{
    public static $wrap = 'article';
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'category_id' => $this->category_id,
            'direction'   => $this->direction?->getTranslations('name'),
            'year'        => $this->year->format('Y'),
            'journal'     => $this->journal,
            'part'        => $this->part,
            'number'      => $this->number,
            'pages'       => $this->pages,
            'publisher'   => $this->publisher,
            'patent_number' => $this->patent_number,
            'app_number'    => $this->app_number,
            'city_id'       => $this->city_id,
            'city'          => $this->city,
            'country_id'    => $this->city->country_id,
            'country'       => $this->country,
            'title'         => $this->getTranslations('title'),
            'desc'          => $this->getTranslations('desc'),
            'full_text'     => $this->getTranslations('full_text'),
            'citation_this_count' => $this->citation_this_count,
            'file_path'           => $this->file_path,
            'category'            => new ArticleCategoryResource($this->category),
            'authors'             => AuthorResource::collection($this->authors),
            'tags'                => TagResource::collection($this->tags),
        ];
    }
}
