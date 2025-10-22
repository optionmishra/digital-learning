<?php

namespace App\Services\Migration\Transformers;

use App\Models\Role;
use Illuminate\Support\Facades\Log;

class UserRoleTransformer implements TransformerInterface
{
    public function transform(object $record, array $fieldMappings): array
    {
        // Check if user_type exists in the source record
        if (! property_exists($record, 'user_type') || empty($record->user_type)) {
            Log::debug("Record ID {$record->id} doesn't have valid user_type property");

            return [];
        }

        // Get role_id from user_type
        $role = Role::where('name', strtolower($record->user_type))->first();
        if (! $role) {
            Log::debug("Couldn't determine role_id for user_type '{$record->user_type}'");

            return [];
        }

        return [
            'user_id' => $record->id,
            'role_id' => $role->id,
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
