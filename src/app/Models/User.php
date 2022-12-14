<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Traits\Loggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes, Loggable;

    protected $fillable = [
        'firstname',
        'lastname',
        'username',
        'email',
        'photo',
        'password',
        'last_at',
        'ip_address',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function getFullnameAttribute()
    {
        return $this->attributes['firstname'] . ' ' . $this->attributes['lastname'];
    }

    public function getAvatarAttribute()
    {
        return asset('storage/images/users/' . $this->getAttribute('photo'));
    }

    public function roles()
    {
        return $this->belongsToMany(Role::class, 'role_has_users');
    }

    public function role()
    {
        return $this->roles()->first();
    }

    public function scopeEmployee($query)
    {
        return $query->whereHas('roles', function ($subQuery) {
            $subQuery->where('name', 'employee');
        });
    }

    public function hasRole(string $role)
    {
        return (bool)$this->roles()->where('name', $role)->first();
    }


}
