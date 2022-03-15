<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    protected $fillable=['title_ar','title_en'];
    public function Crops(){
        return $this->belongsToMany(Crop::class,'cities_crops')->withPivot(['quantity','year']);
    }
}
