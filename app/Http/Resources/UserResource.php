<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $token = $this->createToken('MyApp')->plainTextToken;
        return [
            'token' => $token,
            'id' => $this->id,
            'name' => $this->name,
//            'email' => $this->email,
            'mobile' => $this->mobile,
            'img' => $this->profile->img ? asset('users/profile/img/' . $this->profile->img) : null,
            'role' => $this->roles()->first()->name,
//            'dob' => $this->profile->dob,
            'school' => SchoolResource::make($this->profile->school),
            'standard' => StandardsResource::make($this->profile->standard),
        ];
    }
}
