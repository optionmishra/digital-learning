<?php

namespace Database\Seeders;

use App\Models\Board;

class BoardSeeder extends BaseSeeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        self::$board = Board::firstOrCreate(['name' => 'CBSE']);
        Board::firstOrCreate(['name' => 'ICSE']);
    }
}
