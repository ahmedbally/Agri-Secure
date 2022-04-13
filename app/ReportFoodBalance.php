<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ReportFoodBalance extends Model
{
    protected $fillable = ['year', 'group', 'crop', 'production', 'imports', 'stock_first', 'stock_end', 'exports', 'available_consumption', 'animal_food', 'seed', 'industry', 'human_food', 'population', 'pure_food', 'human_year', 'human_day', 'human_cal', 'human_protein', 'human_fat'];

    public function getIndividualProductionAttribute()
    {
        return $this->production / $this->population;
    }

    public function getIndividualAvailableConsumptionAttribute()
    {
        return $this->available_consumption / $this->population;
    }

    public function getIndividualHumanFoodAttribute()
    {
        return $this->human_food / $this->population;
    }
}
