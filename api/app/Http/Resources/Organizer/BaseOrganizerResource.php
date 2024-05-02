<?php

namespace App\Http\Resources\Organizer;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BaseOrganizerResource extends JsonResource
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
            'title' => $this->title,
            'logo_url' => $this->logo_url
        ];
    }
}
