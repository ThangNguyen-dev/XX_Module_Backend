<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SessionRS extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        if ($this->cost == null) {
            $this->cost = 0;
        }
        return [
            'id' => $this->id,
            'title' => $this->title,
            'description' => $this->description,
            'vaccinator' => $this->vaccinator,
            'start' => $this->start,
            'end' => $this->end,
            'type' => $this->type,
            'cost' => $this->cost,
        ];
    }
}
