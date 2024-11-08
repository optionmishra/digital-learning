<?php

namespace Database\Seeders;

use App\Models\Book;
use App\Models\Role;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\User;
use App\Models\Board;
use App\Models\Author;
use App\Models\Content;
use App\Models\ContentType;
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

        $book = Book::firstOrCreate([
            'name' => $subject->name . ' ' . $standard->name,
            'about' => 'Lorem ipsum, dolor sit amet consectetur adipisicing elit. Corporis porro cumque placeat laboriosam voluptatum at. Quo optio neque magnam commodi in, ducimus temporibus eveniet, deserunt nobis nesciunt accusamus asperiores sint.',
            'board_id' => $board->id,
            'standard_id' => $standard->id,
            'subject_id' => $subject->id,
            'author_id' => $author->id,
        ]);

        $contentType = ContentType::firstOrCreate([
            'name' => 'Video',
        ]);
        ContentType::firstOrCreate([
            'name' => 'Ebook',
        ]);

        Content::firstOrCreate(
            ['title' => 'Unknown Brain - Wonder (ft. Rarin & Bri Tolani)'],
            [
                'standard_id' => $standard->id,
                'subject_id' => $subject->id,
                'book_id' => $book->id,
                'content_type_id' => $contentType->id,
                'src' => 'https://youtu.be/sms4FmPjctU',
                'src_type' => 'url',
                'about' => 'All NCS music is copyright free and safe for you to use on platforms like YouTube, TikTok and Twitch. You may not use any track for the purpose of creating a listening experience (i.e., a music video) where the music is the primary focus of the video.',
                'img' => 'https://i.ytimg.com/vi/sms4FmPjctU/maxresdefault.jpg',
                'img_type' => 'url',
                'tags' => 'NCS,2024',
                'price' => null,
                'duration' => '00:02:18',
                'creator' => 'NoCopyrightSounds',
            ]
        );
        Content::firstOrCreate(
            ['title' => 'Hush - Models'],
            [
                'standard_id' => $standard->id,
                'subject_id' => $subject->id,
                'book_id' => $book->id,
                'content_type_id' => $contentType->id,
                'src' => 'https://youtu.be/B2DnkuXC8Rw',
                'src_type' => 'url',
                'about' => 'All NCS music is copyright free and safe for you to use on platforms like YouTube, TikTok and Twitch. You may not use any track for the purpose of creating a listening experience (i.e., a music video) where the music is the primary focus of the video.',
                'img' => 'https://i.ytimg.com/vi/B2DnkuXC8Rw/maxresdefault.jpg',
                'img_type' => 'url',
                'tags' => 'NCS,2024',
                'price' => null,
                'duration' => '00:02:33',
                'creator' => 'NoCopyrightSounds',

            ]
        );
        Content::firstOrCreate(
            ['title' => 'More Plastic - Obsession'],
            [
                'standard_id' => $standard->id,
                'subject_id' => $subject->id,
                'book_id' => $book->id,
                'content_type_id' => $contentType->id,
                'src' => 'https://youtu.be/VKSqafvwLhA',
                'src_type' => 'url',
                'about' => 'All NCS music is copyright free and safe for you to use on platforms like YouTube, TikTok and Twitch. You may not use any track for the purpose of creating a listening experience (i.e., a music video) where the music is the primary focus of the video.',
                'img' => 'https://i.ytimg.com/vi/VKSqafvwLhA/maxresdefault.jpg',
                'img_type' => 'url',
                'tags' => 'NCS,2024',
                'price' => null,
                'duration' => '00:03:24',
                'creator' => 'NoCopyrightSounds',
            ]
        );
        Content::firstOrCreate(
            ['title' => 'Rameses B - i want u'],
            [
                'standard_id' => $standard->id,
                'subject_id' => $subject->id,
                'book_id' => $book->id,
                'content_type_id' => $contentType->id,
                'src' => 'https://youtu.be/u-8vtlakNy0',
                'src_type' => 'url',
                'about' => 'All NCS music is copyright free and safe for you to use on platforms like YouTube, TikTok and Twitch. You may not use any track for the purpose of creating a listening experience (i.e., a music video) where the music is the primary focus of the video.',
                'img' => 'https://i.ytimg.com/vi/u-8vtlakNy0/maxresdefault.jpg',
                'img_type' => 'url',
                'tags' => 'NCS,2024',
                'price' => null,
                'duration' => '00:03:18',
                'creator' => 'NoCopyrightSounds',
            ]
        );
        Content::firstOrCreate(
            ['title' => 'Mangoo, B3nte - Perfection (feat. Derek Cate)'],
            [
                'standard_id' => $standard->id,
                'subject_id' => $subject->id,
                'book_id' => $book->id,
                'content_type_id' => $contentType->id,
                'src' => 'https://youtu.be/tAHs5GVIjh0',
                'src_type' => 'url',
                'about' => 'All NCS music is copyright free and safe for you to use on platforms like YouTube, TikTok and Twitch. You may not use any track for the purpose of creating a listening experience (i.e., a music video) where the music is the primary focus of the video.',
                'img' => 'https://i.ytimg.com/vi/tAHs5GVIjh0/maxresdefault.jpg',
                'img_type' => 'url',
                'tags' => 'NCS,2024',
                'price' => null,
                'duration' => '00:02:44',
                'creator' => 'NoCopyrightSounds',
            ]
        );
    }
}
