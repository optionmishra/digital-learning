<?php

namespace App\Services\Migration\Transformers;

use Illuminate\Support\Facades\Hash;

class UserTransformer implements TransformerInterface
{
  public function transform(object $record, array $fieldMappings): array
  {
    $mappedData = [];

    foreach ($fieldMappings as $sourceField => $targetField) {
      if (property_exists($record, $sourceField)) {
        // Special handling for password
        if ($sourceField === 'password') {
          $mappedData[$targetField] = Hash::make($record->$sourceField);
        } else {
          $mappedData[$targetField] = $record->$sourceField;
        }
      }
    }

    return $mappedData;
  }
}
