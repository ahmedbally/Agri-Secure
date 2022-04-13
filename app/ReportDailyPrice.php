<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ReportDailyPrice extends Model
{
    protected $fillable = [
        'date', 'group', 'crop', 'unit', 'wholesale_lower', 'wholesale_higher', 'wholesale_average', 'retail_lower', 'retail_higher', 'retail_average',
    ];

    protected $casts = [
        'date' => 'date',
    ];
}
