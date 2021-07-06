<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Citizent extends Model
{
    public $timestamps = false;
    public $guarded = [];

    public $table = 'citizens';

    public function registration()
    {
        return $this->hasMany(Registration::class, 'citizen_id');
    }
}
