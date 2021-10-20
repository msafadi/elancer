<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User;

class Admin extends User
{
    use HasFactory;

    protected $fillable = [
        'name', 'email', 'super_admin', 'status', 'remember_token',
    ];
}
