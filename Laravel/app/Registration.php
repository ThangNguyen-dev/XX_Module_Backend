<?php

namespace App;

use App\Http\Resources\CampaignRS;
use Illuminate\Database\Eloquent\Model;

class Registration extends Model
{
    public $timestamps = false;
    public $guarded = [];

    public function ticket()
    {
        return $this->belongsTo(Campaign_ticket::class, 'ticket_id');
    }

    public function session_registration()
    {
        return $this->hasMany(Session_registration::class, 'registration_id');
    }
}
