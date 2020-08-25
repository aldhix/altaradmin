<?php

namespace Aldhix\Altaradmin\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticable;
use Illuminate\Notifications\Notifiable;

class Admin extends Authenticable
{
	use Notifiable;

	protected $guard = 'admin';

    protected $fillable = [
        'name', 'email', 'password','level','email_verified_at','photo'
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];
    
}
