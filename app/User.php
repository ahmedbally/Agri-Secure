<?php

namespace App;

use Cog\Laravel\Optimus\Facades\Optimus;
use Cog\Laravel\Optimus\Traits\OptimusEncodedRouteKey;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Traits\Voter;

class User extends Authenticatable
{
    use Notifiable;
    use Voter;
    use OptimusEncodedRouteKey;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'mobile',
        'password',
        'photo',
        'permissions_id',
        'status',
        'permissions',
        'connect_email',
        'connect_password',
        'provider_id',
        'provider',
        'access_token'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    // relation with Permissions
    public function permissionsGroup()
    {

        return $this->belongsTo('App\Permissions', 'permissions_id');
    }
}
