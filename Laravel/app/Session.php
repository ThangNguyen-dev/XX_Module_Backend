<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Session extends Model
{
    public $timestamps = false;
    public $guarded = [];

    public static function isTimeConflict($time, $session_id)
    {
        if (isset($session_id)) {
            if (
                Session::where('id', '<>', $session_id)->where('start', '<=', $time['start'])->where('end', '>=', $time['end'])->first() ||
                Session::where('id', '<>', $session_id)->where('start', '>=', $time['start'])->where('end', '<=', $time['end'])->first() ||
                Session::where('id', '<>', $session_id)->where('start', '>=', $time['start'])->where('end', '>=', $time['end'])->where('start', '<=', $time['end'])->first() ||
                Session::where('id', '<>', $session_id)->where('start', '<=', $time['start'])->where('end', '<=', $time['end'])->where('end', '>=', $time['start'])->first()
            ) {
                return true;
            }
            return false;
        } else {
            if (
                Session::where('start', '<=', $time['start'])->where('end', '>=', $time['end'])->first() ||
                Session::where('start', '>=', $time['start'])->where('end', '<=', $time['end'])->first() ||
                Session::where('start', '>=', $time['start'])->where('end', '>=', $time['end'])->where('start', '<=', $time['end'])->first() ||
                Session::where('start', '<=', $time['start'])->where('end', '<=', $time['end'])->where('end', '>=', $time['start'])->first()
            ) {
                return true;
            }
            return false;
        }
    }

    public function place()
    {
        return $this->belongsTo(Place::class, 'place_id');
    }

    public function session_registration()
    {
        return $this->hasMany(Session_registration::class, 'session_id');
    }
}
