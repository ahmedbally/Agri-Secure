<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Permissions extends Model
{
    protected $casts = [
        'status' => 'boolean'
    ];

    public function users()
    {
        return $this->hasMany('App\User', 'permissions_id');
    }
}
