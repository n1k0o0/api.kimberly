<?php

namespace App\Http\Resources\Dashboard\User;

use App\Http\Resources\School\SchoolResource;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'patronymic' => $this->patronymic ?? '',
            'type' => $this->type,
            'status' => $this->status,
            'full_name' => $this->full_name,
            'email' => $this->email,
            'phone' => $this->phone ?? '',
            'created_at' => optional($this->created_at)->timestamp,
            'school' => SchoolResource::make($this->whenLoaded('school')),
            'avatar' => UserAvatarResource::make($this->whenLoaded('avatar')),
        ];
    }
}
