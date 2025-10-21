<?php

namespace Database\Seeders;

use App\Models\Role;

class RoleSeeder extends BaseSeeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        self::$adminRole = Role::firstOrCreate(['name' => 'admin']);
        self::$teacherRole = Role::firstOrCreate(['name' => 'teacher']);
        self::$studentRole = Role::firstOrCreate(['name' => 'student']);
        self::$demoRole = Role::firstOrCreate(['name' => 'demo']);
    }
}
