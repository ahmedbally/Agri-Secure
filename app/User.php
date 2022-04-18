<?php

namespace App;

use App\Traits\Voter;
use Cog\Laravel\Optimus\Facades\Optimus;
use Cog\Laravel\Optimus\Traits\OptimusEncodedRouteKey;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Vanthao03596\LaravelPasswordHistory\HasPasswordHistory;

class User extends Authenticatable
{
    use Notifiable;
    use Voter;
    use OptimusEncodedRouteKey;
    use HasPasswordHistory;

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
        'access_token',
    ];

    protected $casts = [
        'status' => 'boolean'
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
