<?php

namespace Database\Seeders;

use App\Models\Book;
use App\Models\Role;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\User;
use App\Models\Board;
use App\Models\Author;
use App\Models\Subject;
use App\Models\Standard;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Role::firstOrCreate(['name' => 'admin']);
        Role::firstOrCreate(['name' => 'user']);

        $user = User::firstOrCreate(
            ['email' => 'admin@example.com'],
            ['name' => 'Admin', 'password' => 'password']
        );

        $user->assignRole('admin');

        $board = Board::firstOrCreate(['name' => 'CBSE']);
        Board::firstOrCreate(['name' => 'ICSE']);

        $standard = Standard::firstOrCreate(['name' => 'Nursery', 'order' => '1']);
        Standard::firstOrCreate(['name' => 'LKG', 'order' => '2']);
        Standard::firstOrCreate(['name' => 'UKG', 'order' => '3']);
        Standard::firstOrCreate(['name' => 'Class 1', 'order' => '4']);
        Standard::firstOrCreate(['name' => 'Class 2', 'order' => '5']);
        Standard::firstOrCreate(['name' => 'Class 3', 'order' => '6']);
        Standard::firstOrCreate(['name' => 'Class 4', 'order' => '7']);
        Standard::firstOrCreate(['name' => 'Class 5', 'order' => '8']);

        $subject = Subject::firstOrCreate(['name' => 'English']);
        Subject::firstOrCreate(['name' => 'Hindi']);
        Subject::firstOrCreate(['name' => 'Mathematics']);
        Subject::firstOrCreate(['name' => 'Science']);
        Subject::firstOrCreate(['name' => 'Social Science']);

        $author = Author::firstOrCreate(['name' => 'John Doe']);

        Book::firstOrCreate([
            'name' => $subject->name . ' ' . $standard->name,
            'about' => 'Lorem ipsum, dolor sit amet consectetur adipisicing elit. Corporis porro cumque placeat laboriosam voluptatum at. Quo optio neque magnam commodi in, ducimus temporibus eveniet, deserunt nobis nesciunt accusamus asperiores sint.',
            'board_id' => $board->id,
            'standard_id' => $standard->id,
            'subject_id' => $subject->id,
            'author_id' => $author->id,
        ]);
    }
}
