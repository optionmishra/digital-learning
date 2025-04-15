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
            ['img' => 'English.png']
        );
        Subject::firstOrCreate(
            ['name' => 'Hindi'],
            ['img' => 'Hindi.png']
        );
        Subject::firstOrCreate(
            ['name' => 'Mathematics'],
            ['img' => 'Maths.png']
        );
        Subject::firstOrCreate(
            ['name' => 'Science'],
            ['img' => 'Science.png']
        );
        Subject::firstOrCreate(
            ['name' => 'Social Science'],
            ['img' => 'Social-Science.png']
        );
    }
}
