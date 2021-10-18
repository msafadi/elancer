<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Str;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    // User has one freelaner profile
    public function freelancer()
    {
        return $this->hasOne(Freelancer::class, 'user_id', 'id')
            ->withDefault();
    }

    public function projects()
    {
        return $this->hasMany(Project::class, 'user_id', 'id');
    }

    // Accessor Methods
    // $user->profile_photo_url
    public function getProfilePhotoUrlAttribute()
    {
        if ($this->freelancer->profile_photo_path) {
            return asset('storage/' . $this->freelancer->profile_photo_path);
        }
        return asset('images/default-photo.jpg');
    }

    // $this->name
    public function getNameAttribute($value)
    {
        return Str::title($value);
    }

    // Mutators
    // $user->email = "M@Safadi.ps" -> "m@safadi.ps"
    public function setEmailAttribute($value)
    {
        $this->attributes['email'] = Str::lower($value);
    }
}
