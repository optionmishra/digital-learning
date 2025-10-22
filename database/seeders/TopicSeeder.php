<?php

namespace Database\Seeders;

use App\Models\Topic;

class TopicSeeder extends BaseSeeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        self::$topic = Topic::firstOrCreate(
            ['name' => 'Active and Passive voice'],
            ['subject_id' => self::$subject->id, 'book_id' => self::$book->id]
        );
    }
}
