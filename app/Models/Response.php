<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Response extends Model
{
    use HasFactory;

    protected $fillable = ['survey_id', 'question_id', 'answer'];

    /**
     * Get the survey that owns this response.
     */
    public function survey()
    {
        return $this->belongsTo(Survey::class);
    }

    /**
     * Get the question that this response answers.
     */
    public function question()
    {
        return $this->belongsTo(Question::class);
    }
}
