<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class RegistrationRS extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $session_ids = array();
        foreach ($this->session_registration as $session_regisrtation) {
            array_push($session_ids, $session_regisrtation->session_id);
        }
        return
            [
                'campaign' => new CampaignRS($this->ticket->campaign),
                'session_ids' => $session_ids,
            ];
    }
}
