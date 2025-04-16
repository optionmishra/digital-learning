<?php

namespace App\Services\Migration\Transformers;

interface TransformerInterface
{
  /**
   * Transform a database record from source to target format
   *
   * @param object $record The source record
   * @param array $fieldMappings Field mappings for the target table
   * @return array Transformed data ready for insertion
   */
  public function transform(object $record, array $fieldMappings): array;
}
