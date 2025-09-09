<?php

namespace Database\Seeders;

use App\Models\Config;

class ConfigSeeder extends BaseSeeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Config::firstOrCreate(
            ['key' => 'series'],
            ['value' => 'true']
        );

        Config::firstOrCreate(
            ['key' => 'author'],
            ['value' => 'false']
        );
    }
}
