<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reward extends Model
{
    use HasFactory;

    protected $fillable = [
        'employee_id',
        'points',
        'badges', // This field is assumed to be stored as JSON
    ];

    // Cast badges to an array automatically when accessed
    protected $casts = [
        'badges' => 'array',
    ];

    // Relationship: Each reward belongs to one employee
    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
}
