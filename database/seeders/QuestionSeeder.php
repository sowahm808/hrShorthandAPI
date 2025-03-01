<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class QuestionSeeder extends Seeder
{
    public function run()
    {
        DB::table('questions')->insert([
            [
                'text' => 'How aware are you of the company vision?',
                'type' => 'rating',
                'is_required' => true,
                'order' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'text' => 'Do you view your skills as an asset to the company?',
                'type' => 'radio',
                'is_required' => true,
                'order' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'text' => 'How clear are your job expectations?',
                'type' => 'rating',
                'is_required' => true,
                'order' => 3,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'text' => 'How would you rate coworker support and collaboration?',
                'type' => 'rating',
                'is_required' => true,
                'order' => 4,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'text' => 'Are necessary resources available for your tasks?',
                'type' => 'radio',
                'is_required' => true,
                'order' => 5,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'text' => 'Overall job satisfaction and would you recommend this job?',
                'type' => 'text',
                'is_required' => true,
                'order' => 6,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'text' => 'Do you see long-term commitment here? Suggestions for improvement?',
                'type' => 'text',
                'is_required' => true,
                'order' => 7,
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }
}
