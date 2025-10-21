<?php

namespace App\Services\Migration\Transformers;

class DefaultTransformer implements TransformerInterface
{
    public function transform(object $record, array $fieldMappings): array
    {
        $mappedData = [];

        foreach ($fieldMappings as $sourceField => $targetField) {
            if (property_exists($record, $sourceField)) {
                $mappedData[$targetField] = $record->$sourceField;
            }
        }

        return $mappedData;
    }
}
