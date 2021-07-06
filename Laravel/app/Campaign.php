<?php

namespace App;

use App\Http\Resources\OrganizerRS;
use Illuminate\Database\Eloquent\Model;

class Campaign extends Model
{
    public $timestamps = false;
    public $guarded = [];

    public function registration()
    {
        return $this->hasManyThrough(Registration::class, Campaign_ticket::class, 'campaign_id', 'ticket_id');
    }

    public function ticket()
    {
        return $this->hasMany(Campaign_ticket::class, 'campaign_id');
    }

    public function place()
    {
        return $this->hasManyThrough(Place::class, Area::class, 'campaign_id', 'area_id');
    }

    public function area()
    {
        return $this->hasMany(Area::class);
    }

    public function organizer()
    {
        return $this->belongsTo(Organizer::class, 'organizer_id');
    }
}
