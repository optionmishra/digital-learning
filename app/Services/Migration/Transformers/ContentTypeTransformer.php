<?php

namespace App\Services\Migration\Transformers;

use App\Models\Role;
use Illuminate\Support\Facades\Log;

class ContentTypeTransformer implements TransformerInterface
{
  public function transform(object $record, array $fieldMappings): array
  {
    $mappedData = [];

    foreach ($fieldMappings as $sourceField => $targetField) {
      if (property_exists($record, $sourceField)) {
        // Special handling for 'allow' field
        if ($sourceField === 'allow') {
          if ($record->$sourceField === 'Both') {
            $mappedData[$targetField] = null;
          } else {
            $role = Role::where('name', strtolower($record->$sourceField))->first();
            $mappedData[$targetField] = $role ? $role->id : null;
          }
        } else {
          $mappedData[$targetField] = $record->$sourceField;
        }
      }
    }

    return $mappedData;
  }
}
