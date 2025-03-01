<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Survey;
use App\Models\Employee;

class SurveySeeder extends Seeder
{
    public function run()
    {
        // Get all employees
        $employees = Employee::all();

        foreach ($employees as $employee) {
            // Create surveys for each employee
            Survey::create([
                'employee_id' => $employee->id,
                'survey_date' => now()
            ]);
        }
    }
}
