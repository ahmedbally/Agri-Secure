<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CityCrop extends Model
{
    protected $table = 'cities_crops';

    public $timestamps = false;

    public function Crop()
    {
        return $this->belongsTo(Crop::class);
    }

    public function City()
    {
        return $this->belongsTo(City::class);
    }

    public function Center()
    {
        return $this->belongsTo(Center::class);
    }
}
