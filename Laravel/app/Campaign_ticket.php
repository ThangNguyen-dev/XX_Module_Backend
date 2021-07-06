<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Campaign_ticket extends Model
{
    public $timestamps = false;
    public $guarded = [];
    public $available = true;

    public function campaign()
    {
        return $this->belongsTo(Campaign::class, 'campaign_id');
    }

    public function description()
    {
        $special_validity = json_decode($this->special_validity);
        if ($special_validity) {
            if ($special_validity &&  $special_validity->type == 'date') {
                return 'Available until ' . date('F d, Y', strtotime($special_validity->date));
            } elseif ($special_validity &&  $special_validity->type == 'amount') {
                return $special_validity->amount . ' tickets available';
            };
        }
    }

    public static function setSpecialValidity($special_validity)
    {
        if ($special_validity['type'] == 'date') {
            return json_encode(
                [
                    'type' => $special_validity['type'],
                    $special_validity['type'] => $special_validity['value'],
                ]
            );
        } else {
            return json_encode(
                [
                    'type' => $special_validity['type'],
                    $special_validity['type'] => $special_validity['value'],
                ]
            );
        }
    }

    public function registration()
    {
        return $this->hasMany(Registration::class, 'ticket_id');
    }

    public function available()
    {
        $specialValidity = json_decode($this->special_validity, true);
        $this->available = true;
        $this->description = '';
        if ($specialValidity != null) {
            if ($specialValidity['type'] == 'date') {
                $this->description = 'Available until ' . date('F', strtotime($specialValidity['date'])) . ' ' . date('j', strtotime($specialValidity['date'])) . ', ' . date('Y', strtotime($specialValidity['date']));
                if ($specialValidity['date'] < Carbon::now()->format('Y-m-d')) {
                    $this->available = false;
                }
            } else {
                $this->description = $specialValidity['amount'] . ' tickets available';
                if ((int)$specialValidity['amount'] <= (int)$this->registration->count())
                    $this->available = false;
            }
        }
    }
}
