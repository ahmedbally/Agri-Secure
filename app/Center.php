<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Center extends Model
{
    protected $fillable=["title_ar","title_en","city_id"];
    public function City(){
        return $this->belongsTo(City::class);
    }

}
