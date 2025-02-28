<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Survey extends Model
{
    use HasFactory;

    protected $fillable = ['employee_id', 'survey_date'];

    public function responses()
    {
        return $this->hasMany(Response::class);
    }
}

