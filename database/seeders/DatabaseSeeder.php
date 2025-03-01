<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // Register all the seeders
        $this->call([
            EmployeeSeeder::class,
            QuestionSeeder::class,
            SurveySeeder::class,
            RewardSeeder::class,
            EmployeeSeeder::class,

        ]);
    }
}
