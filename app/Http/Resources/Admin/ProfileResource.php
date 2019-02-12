<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Resources\Json\JsonResource;

class ProfileResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return[
            'id' => $this->id,
            'name' => $this->name,
            'lastname' => $this->lastname,
            'fullname' => $this->fullname,
            'birthday' => $this->birthday ? $this->birthday->toDateString() : null,
            'gender' => $this->gender,
            'smallAvatar' => $this->smallAvatar,
            'avatar' => $this->smallAvatar,
            'phone' => $this->phone,
            'email' => $this->email,
            'location' => $this->location,
            'age' => $this->age,
            'refToken' => $this->getRefToken(),
            'role' => $this->roles()->first() ? [
                'id' => $this->roles()->first()->id,
                'label' => $this->roles()->first()->name
            ] : null
        ];
    }
}
