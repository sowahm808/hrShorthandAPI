<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Employee;
use Illuminate\Support\Facades\Hash;
use Faker\Factory as Faker;

class EmployeeSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();

        // Optionally, create a default employee
        Employee::create([
            'id' => 1234567,
            'name'     => 'John Doe',
            'email'    => 'john@example.com',
            'password' => Hash::make('password123'),
        ]);

        // Create 10 additional sample employees
        for ($i = 0; $i < 10; $i++) {
            Employee::create([
                'name'     => $faker->name,
                'email'    => $faker->unique()->safeEmail,
                'password' => Hash::make('password123'),
            ]);
        }
    }
}
