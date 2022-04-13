<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ReportInternationalPrice extends Model
{
    public $timestamps = false;

    protected $fillable = ['crop', 'unit', 'close_cent', 'close_dollar', 'close_pound', 'lower_cent', 'lower_dollar', 'lower_pound', 'higher_cent', 'higher_dollar', 'higher_pound'];
}
