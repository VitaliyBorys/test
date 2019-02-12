<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->fullname,
            'avatar' => $this->smallAvatar,
            'age' => $this->age,
            'confirmed' => $this->confirmed,
            'created_at' => $this->created_at->toDateTimeString(),
        ];
    }
}
