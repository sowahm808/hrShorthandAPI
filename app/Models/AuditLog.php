<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AuditLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'employee_id',
        'survey_id',
        'description',
    ];

    // An audit log entry can belong to an employee (if applicable)
    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    // An audit log entry can belong to a survey (if applicable)
    public function survey()
    {
        return $this->belongsTo(Survey::class);
    }
}
