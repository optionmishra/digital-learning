<?php

namespace Database\Seeders;

use App\Models\Assessment;

class AssessmentSeeder extends BaseSeeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        self::$assessment = Assessment::firstOrCreate(
            [
                'name' => 'Active and Passive voice',
            ],
            [
                'standard_id' => self::$standard->id,
                'subject_id' => self::$subject->id,
                'book_id' => self::$book->id,
                'duration' => '00:05:00',
            ]
        );
    }
}
