<?php

namespace Database\Seeders;

use App\Models\Book;

class BookSeeder extends BaseSeeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        self::$book = Book::firstOrCreate([
            'name' => self::$subject->name.' '.self::$standard->name,
            'about' => 'Lorem ipsum, dolor sit amet consectetur adipisicing elit. Corporis porro cumque placeat laboriosam voluptatum at. Quo optio neque magnam commodi in, ducimus temporibus eveniet, deserunt nobis nesciunt accusamus asperiores sint.',
            'board_id' => self::$board->id,
            'standard_id' => self::$standard->id,
            'subject_id' => self::$subject->id,
            'author_id' => self::$author->id,
        ]);

        Book::firstOrCreate([
            'name' => self::$subject->name.' Akshar Gyan '.self::$standard->name,
            'about' => 'Lorem ipsum, dolor sit amet consectetur adipisicing elit. Corporis porro cumque placeat laboriosam voluptatum at. Quo optio neque magnam commodi in, ducimus temporibus eveniet, deserunt nobis nesciunt accusamus asperiores sint.',
            'board_id' => self::$board->id,
            'standard_id' => self::$standard->id,
            'subject_id' => 2,
            'author_id' => self::$author->id,
        ]);
    }
}
