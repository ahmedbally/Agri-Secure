<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Crop extends Model
{
    protected $fillable=["title_ar","title_en","color","image"];
    public function Cities(){
        return $this->belongsToMany(City::class,'cities_crops')->withPivot(['quantity','year']);
    }
}
