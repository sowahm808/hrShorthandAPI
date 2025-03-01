<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Reward;
use App\Models\Employee;

class RewardSeeder extends Seeder
{
    public function run()
    {
        $employees = Employee::all();

        foreach ($employees as $employee) {
            Reward::create([
                'employee_id' => $employee->id,
                'points' => rand(10, 100),
                'badges' => json_encode(['Consistent Contributor', 'Team Player'])
            ]);
        }
    }
}
