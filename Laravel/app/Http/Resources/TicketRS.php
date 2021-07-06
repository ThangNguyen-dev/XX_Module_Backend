<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TicketRS extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $this->available();
        return [
            'id' => $this->id,
            'name' => $this->name,
            'cost' => (int)number_format($this->cost, 0),
            'available' => $this->available,
            'description' => $this->description,
        ];
    }
}
