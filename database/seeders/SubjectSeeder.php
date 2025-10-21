<?php

namespace Database\Seeders;

use App\Models\Subject;

class SubjectSeeder extends BaseSeeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        self::$subject = Subject::firstOrCreate(
            ['name' => 'English'],
            ['img' => 'English.png', 'status' => 1]
        );
        Subject::firstOrCreate(
            ['name' => 'Hindi'],
            ['img' => 'Hindi.png', 'status' => 1]
        );
        Subject::firstOrCreate(
            ['name' => 'Mathematics'],
            ['img' => 'Maths.png', 'status' => 1]
        );
        Subject::firstOrCreate(
            ['name' => 'Science'],
            ['img' => 'Science.png', 'status' => 1]
        );
        Subject::firstOrCreate(
            ['name' => 'Social Science'],
            ['img' => 'Social-Science.png', 'status' => 1]
        );
    }
}
