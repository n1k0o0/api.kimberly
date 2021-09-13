<?php

namespace App\Http\Resources\Dashboard\School;

use Illuminate\Http\Resources\Json\JsonResource;

class SchoolAvatarResource extends JsonResource
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
            'id' => $this->file_name,
            'mime_type' => $this->mime_type,
            'file_name' => $this->file_name,
            'name' => $this->name,
            'url' => $this->getUrl(),
        ];
    }
}
