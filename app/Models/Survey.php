<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Survey extends Model
{
    use HasFactory;

    protected $fillable = ['employee_id', 'survey_date'];

    /**
     * A survey belongs to an employee.
     */
    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    /**
     * A survey has many responses.
     */
    public function responses()
    {
        return $this->hasMany(Response::class);
    }

    /**
     * Get all questions through responses.
     */
    public function questions()
    {
        return $this->hasManyThrough(Question::class, Response::class, 'survey_id', 'id', 'id', 'question_id');
    }
}
