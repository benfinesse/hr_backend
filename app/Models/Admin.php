<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Admin extends Model
{
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
    ];
}
