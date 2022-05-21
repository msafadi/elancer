<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User;
use Illuminate\Notifications\Notifiable;

class Admin extends User
{
    use HasFactory;
    use Notifiable;

    protected $fillable = [
        'name', 'email', 'super_admin', 'status', 'remember_token',
    ];

    public function hasAbility($ability)
    {
        return true;
    }
}
