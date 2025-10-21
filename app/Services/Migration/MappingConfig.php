<?php

namespace App\Services\Migration;

class MappingConfig
{
    public function getTableMappings(): array
    {
        return [
            'board' => 'boards',
            'category' => 'content_types',
            'classes' => 'standards',
            'main_subject' => 'subjects',
            'notifications' => 'notifications',
            'subject' => 'books',
            'web_user' => ['users', 'user_role', 'user_profiles'],
        ];
    }

    public function getFieldMappings(): array
    {
        return [
            'boards' => [
                'id' => 'id',
                'name' => 'name',
                'date' => 'created_at',
                'date' => 'updated_at',
            ],
            'content_types' => [
                'id' => 'id',
                'name' => 'name',
                'image' => 'img',
                'allow' => 'role_id',
                'orderb' => 'order',
                'date' => 'created_at',
                'date' => 'updated_at',
            ],
            'standards' => [
                'id' => 'id',
                'name' => 'name',
                'class_position' => 'order',
                'date' => 'created_at',
                'date' => 'updated_at',
            ],
            'subjects' => [
                'id' => 'id',
                'name' => 'name',
                'serial' => 'order',
                'date' => 'created_at',
                'date' => 'updated_at',
            ],
            'notifications' => [
                'id' => 'id',
                'title' => 'title',
                'description' => 'description',
                'created_at' => 'created_at',
                'created_at' => 'updated_at',
            ],
            'books' => [
                'id' => 'id',
                'name' => 'name',
                'img' => 'img',
                'class' => 'standard_id',
                'sid' => 'subject_id',
                'date' => 'created_at',
                'date' => 'updated_at',
            ],
            'users' => [
                'id' => 'id',
                'fullname' => 'name',
                'email' => 'email',
                'password' => 'password',
                'date' => 'created_at',
                'date' => 'updated_at',
            ],
            'user_role' => [
                'id' => 'user_id',
                'user_type' => 'role_id',
            ],
            'user_profiles' => [
                'id' => 'user_id',
                'mobile' => 'mobile',
                'dob' => 'dob',
                'dp' => 'img',
                'school_name' => 'school',
                'classes' => 'standard_id',
                'status' => 'status',
            ],
        ];
    }

    // Optionally implement methods to load mappings from config files
    // public function loadTableMappingsFromConfig(): array
    // {
    //     return config('migrations.table_mappings', $this->getTableMappings());
    // }
}
