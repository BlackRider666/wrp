<?php

namespace App\Http\Resources\Article;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SimpleArticleResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'full_title' => $this->full_title,
            'category' => new ArticleCategoryResource($this->category),
            'year'     => $this->year->format('Y'),
            'citation_this_count' => $this->citation_this_count,
        ];
    }
}
