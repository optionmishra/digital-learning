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
            'email' => $this->email,
            'mobile' => $this->profile->mobile,
            'img' => asset('users/profile/img/' . $this->profile->img),
            'role' => $this->roles()->first()->name,
            'dob' => $this->profile->dob,
            'school' => $this->profile->school,
            'standard' => $this->profile->standard_id,
        ];
    }
}
