<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PrizeResource extends JsonResource
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
            'title' => $this->getTitle(),
            'type' => $this->prize_type,
            'value' => $this->value,
            'created_at' => $this->created_at->toDateTimeString(),
            'prize' => $this->physicalPrize()->first(),
            'status' => $this->getStatus(),
            'actions' => $this->getActions()
        ];
    }
}
