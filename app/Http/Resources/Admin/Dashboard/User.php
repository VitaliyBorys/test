<?php

namespace App\Http\Resources\Admin\Dashboard;

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
            'status' => $this->confirmed,
            'name' => $this->fullname,
            'country' => $this->country->name ?? '',
            'created_at' => $this->created_at->toDateTimeString(),
            'avatar' => $this->smallAvatar,
            'last_login' => $this->last_login
        ];
    }
}
