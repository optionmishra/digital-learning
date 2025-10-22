<?php

namespace Database\Seeders;

use App\Models\Author;

class AuthorSeeder extends BaseSeeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        self::$author = Author::firstOrCreate(['name' => 'John Doe']);
    }
}
