<?php

namespace App\Services\Migration\Transformers;

class UserProfileTransformer implements TransformerInterface
{
    public function transform(object $record, array $fieldMappings): array
    {
        $mappedData = [];

        foreach ($fieldMappings as $sourceField => $targetField) {
            if (property_exists($record, $sourceField)) {
                // Special handling for specific fields
                if ($sourceField === 'classes') {
                    // Assuming classes is an array or comma-separated string
                    $classes = is_array($record->$sourceField) ? $record->$sourceField : explode(',', $record->$sourceField);
                    $mappedData[$targetField] = $classes[0] ?? null;
                } elseif ($sourceField === 'status') {
                    $mappedData[$targetField] = $record->$sourceField == 1 ? 'approved' : 'rejected';
                } else {
                    $mappedData[$targetField] = $record->$sourceField;
                }
            }
        }

        return $mappedData;
    }
}
