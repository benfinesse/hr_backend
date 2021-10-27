<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Admin extends Authenticatable
{
    use Notifiable;
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'uuid',
        'email_verified_at',
        'password',
        'phone',
        'dob',
        'image',
        'address',
        'token',
        'u_token_exp',
    ];
}
