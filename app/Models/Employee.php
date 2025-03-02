<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Employee extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    // Fillable properties for mass assignment
    protected $fillable = [
        'name',
        'email',
        'password',
        'role'
    ];

    // Hide sensitive fields when serializing
    protected $hidden = [
        'password',
        'remember_token',
    ];

    // Automatically cast attributes
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    // Automatically hash password when setting it
    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = bcrypt($value);
    }

    // Relationships

    // An employee can have many surveys
    public function surveys()
    {
        return $this->hasMany(Survey::class);
    }

    // An employee has one reward record
    public function reward()
    {
        return $this->hasOne(Reward::class);
    }

    // An employee may have many audit logs (if they trigger actions)
    public function auditLogs()
    {
        return $this->hasMany(AuditLog::class);
    }

    public function isAdmin()
    {
        return $this->role === 'admin';
    }
}
