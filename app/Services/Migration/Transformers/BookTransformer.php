<?php

namespace App\Services\Migration\Transformers;

use App\Models\Board;
use App\Models\Subject;
use Illuminate\Support\Facades\Log;

class BookTransformer implements TransformerInterface
{
    public function transform(object $record, array $fieldMappings): array
    {
        $mappedData = [];

        foreach ($fieldMappings as $sourceField => $targetField) {
            if (property_exists($record, $sourceField)) {
                $mappedData[$targetField] = $record->$sourceField;
            }
        }

        // Add board_id if possible
        if (property_exists($record, 'sid')) {
            try {
                // Try to get the subject to determine the board
                $subject = Subject::find($record->sid);
                if ($subject && $subject->board_id) {
                    $mappedData['board_id'] = $subject->board_id;
                }
            } catch (\Exception $e) {
                Log::debug("Could not determine board_id for book record ID {$record->id}: ".$e->getMessage());
            }
        }

        return $mappedData;
    }
}
