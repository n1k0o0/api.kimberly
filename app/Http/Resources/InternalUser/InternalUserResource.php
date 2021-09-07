<?php

namespace App\Http\Resources\InternalUser;

use Illuminate\Http\Resources\Json\JsonResource;

class InternalUserResource extends JsonResource
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
            'login' => $this->login,
            'type' => $this->type,
            'first_name' => $this->first_name ?? '',
            'last_name' => $this->last_name ?? '',
            'patronymic' => $this->patronymic ?? '',
            'full_name' => $this->full_name,
            'phone' => $this->phone ?? '',
            'created_at' => optional($this->created_at)->timestamp,
        ];
    }
}
