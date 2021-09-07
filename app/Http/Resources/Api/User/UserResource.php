<?php

namespace App\Http\Resources\Api\User;

use App\Http\Resources\Api\School\SchoolResource;
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
            'email' => $this->email,
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'patronymic' => $this->patronymic,
            'phone' => $this->phone,
            'type' => $this->type,
            'status' => $this->status,
            'school' => SchoolResource::make($this->whenLoaded('school')),
        ];
    }
}
