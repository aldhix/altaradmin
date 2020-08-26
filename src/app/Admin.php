<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticable;
use Illuminate\Notifications\Notifiable;

class Admin extends Authenticable
{
    use Notifiable;

	protected $guard = 'admin';

    protected $fillable = [
        'name', 'email', 'password','role','email_verified_at','photo'
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];
}
