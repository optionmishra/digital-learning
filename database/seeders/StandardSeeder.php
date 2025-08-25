<?php

namespace Database\Seeders;

use App\Models\Standard;

class StandardSeeder extends BaseSeeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        self::$standard = Standard::firstOrCreate(['name' => 'Nursery', 'order' => '1', 'status' => 1]);
        Standard::firstOrCreate(['name' => 'LKG', 'order' => '2', 'status' => 1]);
        Standard::firstOrCreate(['name' => 'UKG', 'order' => '3', 'status' => 1]);
        Standard::firstOrCreate(['name' => 'Class 1', 'order' => '4', 'status' => 1]);
        Standard::firstOrCreate(['name' => 'Class 2', 'order' => '5', 'status' => 1]);
        Standard::firstOrCreate(['name' => 'Class 3', 'order' => '6', 'status' => 1]);
        Standard::firstOrCreate(['name' => 'Class 4', 'order' => '7', 'status' => 1]);
        Standard::firstOrCreate(['name' => 'Class 5', 'order' => '8', 'status' => 1]);
    }
}
