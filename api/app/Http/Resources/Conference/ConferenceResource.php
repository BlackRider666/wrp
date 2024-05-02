<?php

namespace App\Http\Resources\Conference;

use App\Http\Resources\Article\SimpleArticleResource;
use App\Http\Resources\City\CityResource;
use App\Http\Resources\Country\CountryResource;
use App\Http\Resources\Organizer\BaseOrganizerResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ConferenceResource extends JsonResource
{
    public static $wrap = 'conference';
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
            'date'  => $this->date,
            'city_id' => $this->city_id,
            'user_id' => $this->user_id,
            'file_url' => $this->file_url,
            'country_id' => $this->country_id,
            'city'       => new CityResource($this->city),
            'country'    => new CountryResource($this->country),
            'organizers' => BaseOrganizerResource::collection($this->organizers),
        ];
    }
}
