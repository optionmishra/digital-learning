<?php

namespace Database\Seeders;

class DatabaseSeeder extends BaseSeeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            // BoardSeeder::class,
            // StandardSeeder::class,
            // SubjectSeeder::class,
            // AuthorSeeder::class,
            // BookSeeder::class,
            // AssessmentSeeder::class,
            // TopicSeeder::class,
            // ContentTypeSeeder::class,
            // ContentSeeder::class,
            // QuestionSeeder::class,
            RoleSeeder::class,
            // UserSeeder::class,
        ]);
    }
}
