<?php

namespace App\Http\Resources\Organization;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BaseOrganizationResource extends JsonResource
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
            'name'    => $this->getTranslations('name'),
            'img_url' => $this->img_url,
            'country' => $this->country,
            'city'    => $this->city,
            'rate'    => $this->rate,
        ];
    }
}
