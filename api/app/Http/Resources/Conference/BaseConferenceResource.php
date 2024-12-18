<?php

namespace App\Http\Resources\Conference;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BaseConferenceResource extends JsonResource
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
            'title' => $this->getTranslations('title'),
            'date'  => $this->date->format('d-m-Y'),
        ];
    }
}
