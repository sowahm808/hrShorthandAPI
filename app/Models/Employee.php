<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable; // If using authentication
use Illuminate\Notifications\Notifiable;

class Employee extends Authenticatable
{
    use HasFactory, Notifiable;

    // Fillable properties for mass assignment
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    // Hide sensitive fields when serializing
    protected $hidden = [
        'password',
        'remember_token',
    ];

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
}
