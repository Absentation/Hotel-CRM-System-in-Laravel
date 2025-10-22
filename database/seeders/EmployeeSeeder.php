<?php

namespace Database\Seeders;

use App\Models\Employee;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class EmployeeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Employee::query()->updateOrCreate(
            ['username' => 'superadmin'],
            [
                'name' => 'Super Admin',
                'role' => 'super_admin',
                'password' => Hash::make('secret123'),
            ]
        );
    }
}
