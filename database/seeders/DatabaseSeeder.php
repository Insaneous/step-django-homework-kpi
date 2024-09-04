<?php

namespace Database\Seeders;

use App\Models\Role;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\User;
use App\Models\Department;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        Role::create([
            'name' => 'admin',
        ]);

        Role::create([
            'name' => 'manager',
        ]);

        Role::create([
            'name' => 'employee',
        ]);

        Department::create([
            'name' => 'IT',
        ]);

        Department::create([
            'name' => 'HR',
        ]);

        Department::create([
            'name' => 'Finance',
        ]);

        User::create([
            'name' => 'admin',
            'lastname' => 'admin',
            'email' => 'admin@insaneous.dev',
            'email_verified_at' => now(),
            'password' => 'admin',
            'role_id' => 1,
            'department_id' => 1,
            'remember_token' => Str::random(10),
        ]);
    }
}
