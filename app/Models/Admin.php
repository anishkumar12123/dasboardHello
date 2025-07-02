<?php

namespace App\Models;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Model;

class Admin extends Authenticatable
{
    // protected $guard = 'admin';

    protected $fillable = [
        'email', 'password'
    ];

    protected $hidden = ['password'];
}
