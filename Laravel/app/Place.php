<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Place extends Model
{
    public $timestamps = false;
    public $guarded = [];

    public function session()
    {
        return $this->hasMany(Session::class, 'place_id');
    }

    public function area()
    {
        return $this->belongsTo(Area::class, 'area_id');
    }
}
