<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserProfileResource extends JsonResource
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
            'name' => $this->name,
            'email' => $this->email,
            'mobile' => $this->profile->mobile,
            'dob' => $this->profile->dob,
            'school' => $this->profile->school,
            'standard' => StandardsResource::make($this->standard),
            'img' => asset('users/profile/img/' . $this->profile->img),
        ];
    }
}
