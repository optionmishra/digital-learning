<?php

namespace Database\Seeders;

use App\Models\Content;

class ContentSeeder extends BaseSeeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Content::firstOrCreate(
            ['title' => 'Unknown Brain - Wonder (ft. Rarin & Bri Tolani)'],
            [
                'standard_id' => self::$standard->id,
                'subject_id' => self::$subject->id,
                'book_id' => self::$book->id,
                'topic_id' => self::$topic->id,
                'content_type_id' => self::$videoContentType->id,
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
                'standard_id' => self::$standard->id,
                'subject_id' => self::$subject->id,
                'book_id' => self::$book->id,
                'topic_id' => self::$topic->id,
                'content_type_id' => self::$videoContentType->id,
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
                'standard_id' => self::$standard->id,
                'subject_id' => self::$subject->id,
                'book_id' => self::$book->id,
                'topic_id' => self::$topic->id,
                'content_type_id' => self::$videoContentType->id,
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
                'standard_id' => self::$standard->id,
                'subject_id' => self::$subject->id,
                'book_id' => self::$book->id,
                'topic_id' => self::$topic->id,
                'content_type_id' => self::$videoContentType->id,
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
                'standard_id' => self::$standard->id,
                'subject_id' => self::$subject->id,
                'book_id' => self::$book->id,
                'topic_id' => self::$topic->id,
                'content_type_id' => self::$videoContentType->id,
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
        Content::firstOrCreate(
            ['title' => 'Akshar Gyan Ebook'],
            [
                'standard_id' => self::$standard->id,
                'subject_id' => 2,
                'book_id' => self::$book->id,
                'topic_id' => self::$topic->id,
                'content_type_id' => self::$ebookContentType->id,
                'src' => 'https://epochstudio.net/good_books/flipbooks/akshargyan/index.html',
                'src_type' => 'url',
                'about' => 'All NCS music is copyright free and safe for you to use on platforms like YouTube, TikTok and Twitch. You may not use any track for the purpose of creating a listening experience (i.e., a music video) where the music is the primary focus of the video.',
                'img' => 'https://epochstudio.net/good_books/flipbooks/akshargyan/files/mobile/1.jpg?241102180809',
                'img_type' => 'url',
                'tags' => 'Ebook,2024',
                'price' => 199,
            ]
        );
    }
}
