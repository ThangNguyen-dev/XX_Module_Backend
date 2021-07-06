<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Area extends Model
{
    public $timestamps = false;
    public $guarded = [];

    public function place()
    {
        return $this->hasMany(Place::class);
    }

    public function session()
    {
        return $this->hasManyThrough(Session::class, Place::class, 'area_id', 'place_id');
    }
}
