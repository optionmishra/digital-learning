<?php

namespace Database\Seeders;

use App\Models\ContentType;

class ContentTypeSeeder extends BaseSeeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        self::$videoContentType = ContentType::firstOrCreate([
            'name' => 'Video',
        ]);
        self::$ebookContentType = ContentType::firstOrCreate([
            'name' => 'Ebook',
        ]);
    }
}
