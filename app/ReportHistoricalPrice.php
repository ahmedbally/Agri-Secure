<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ReportHistoricalPrice extends Model
{
    protected $fillable=['year','season','crop','farm_price','trading_price','total_price'];
}
