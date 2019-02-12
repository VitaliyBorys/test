<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class User extends JsonResource
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
            'name' => $this->name,
            'lastname' => $this->lastname,
            'fullname' => $this->fullname,
            'birthday' => $this->birthday ? $this->birthday->toDateString() : null,
            'gender' => $this->gender,
            'smallAvatar' => $this->smallAvatar,
            'avatar' => $this->smallAvatar,
            'phone' => $this->phone,
            'email' => $this->email,
            'age' => $this->age,
            'money' => $this->money,
            'bonuses' => $this->bonuses
        ];
    }
}
