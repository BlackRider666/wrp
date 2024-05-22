<?php

namespace App\Http\Resources\Conference;

use App\Http\Resources\City\CityResource;
use App\Http\Resources\Country\CountryResource;
use App\Http\Resources\Organization\BaseOrganizationResource;
use App\Http\Resources\Organizer\BaseOrganizerResource;
use App\Http\Resources\User\BaseUserResource;
use Illuminate\Http\Request;

class ConferenceResource extends BaseConferenceResource
{
    public static $wrap = 'conference';
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return array_merge(parent::toArray($request),[
            'city_id' => $this->city_id,
            'user_id' => $this->user_id,
            'file_url' => $this->file_url,
            'country_id' => $this->country_id,
            'city'       => new CityResource($this->city),
            'country'    => new CountryResource($this->country),
            'organizers' => BaseOrganizerResource::collection($this->organizers),
            'organizations' => BaseOrganizationResource::collection($this->organizations),
            'org_committee' => BaseUserResource::collection($this->orgCommittee),
            'editors'       => BaseUserResource::collection($this->editors),
        ]);
    }
}
