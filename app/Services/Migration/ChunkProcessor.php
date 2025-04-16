<?php

namespace App\Services\Migration;

use App\Models\Book;
use App\Services\Migration\Transformers\TransformerFactory;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ChunkProcessor
{
  protected $transformerFactory;
  protected $sourceConnection;
  protected $targetConnection;
  protected $debug;

  public function __construct(
    TransformerFactory $transformerFactory,
    string $sourceConnection,
    string $targetConnection,
    bool $debug = false
  ) {
    $this->transformerFactory = $transformerFactory;
    $this->sourceConnection = $sourceConnection;
    $this->targetConnection = $targetConnection;
    $this->debug = $debug;
  }

  public function process($records, string $sourceTable, array $targetTables, array $fieldMappings): void
  {
    foreach ($records as $record) {
      try {
        // Process each target table
        foreach ($targetTables as $targetTable) {
          // Skip if no field mappings for this target table
          if (!isset($fieldMappings[$targetTable])) {
            $this->logDebug("No field mappings defined for target table: {$targetTable}");
            continue;
          }

          $transformer = $this->transformerFactory->getTransformer($sourceTable, $targetTable);

          // Get transformed data
          $mappedData = $transformer->transform($record, $fieldMappings[$targetTable]);

          // Skip if no data to insert
          if (empty($mappedData)) {
            $this->logDebug("No data to insert for {$targetTable} from record ID {$record->id}");
            continue;
          }

          // Insert into target table
          $this->logDebug("Inserting into {$targetTable}: " . json_encode($mappedData));

          DB::connection($this->targetConnection)
            ->table($targetTable)
            ->insertOrIgnore($mappedData);
        }

        // Now handle any many-to-many relationships
        $this->processRelationships($sourceTable, $record);
      } catch (\Exception $e) {
        $message = "Error migrating record ID {$record->id}: " . $e->getMessage();
        Log::error("Migration error for {$sourceTable} ID {$record->id}: " . $e->getMessage());
        $this->logDebug($e->getTraceAsString());
      }
    }
  }

  protected function processRelationships(string $sourceTable, $record): void
  {
    // Handle many-to-many relationships based on source table
    if ($sourceTable === 'subject' && property_exists($record, 'categories')) {
      $this->handleManyToMany(
        $sourceTable,
        $record->id,
        'book_content_types', // pivot table
        'categories',
        'book_id',
        'content_type_id',
        $record->categories
      );
    }

    if ($sourceTable === 'web_user') {
      if (property_exists($record, 'series_classes') && $record->series_classes !== null) {
        $unserializedSeriesClasses = unserialize($record->series_classes);
        $bookIdsArr = [];

        foreach ($unserializedSeriesClasses as $subjectId => $standardIdsArr) {
          // Establish the many-to-many relation for user_standards
          $this->handleManyToMany(
            $sourceTable,
            $record->id,
            'user_standards', // pivot table
            'series_classes',
            'user_id',
            'standard_id',
            $standardIdsArr
          );

          // Retrieve the book IDs that match the subject and standards
          $books = Book::where('subject_id', $subjectId)
            ->whereIn('standard_id', $standardIdsArr)
            ->pluck('id')
            ->toArray();

          // Merge current book IDs into the accumulating array
          $bookIdsArr = array_merge($bookIdsArr, $books);
        }

        // Establish the many-to-many relation for user_books
        $this->handleManyToMany(
          $sourceTable,
          $record->id,
          'user_books', // pivot table
          'series_classes',
          'user_id',
          'book_id',
          $bookIdsArr
        );
      } elseif (property_exists($record, 'subject') && property_exists($record, 'classes')) {
        $this->handleManyToMany(
          $sourceTable,
          $record->id,
          'user_standards', // pivot table
          'series_classes',
          'user_id',
          'standard_id',
          $record->classes
        );

        $bookIdsArr = Book::whereIn('subject_id', explode(',', $record->subject))
          ->whereIn('standard_id', explode(',', $record->classes))
          ->pluck('id')
          ->toArray();

        $this->handleManyToMany(
          $sourceTable,
          $record->id,
          'user_books', // pivot table
          'series_classes',
          'user_id',
          'book_id',
          $bookIdsArr
        );
      }
    }

    // Add more relationship handlers as needed
  }

  protected function handleManyToMany(
    string $sourceTable,
    int $sourceId,
    string $pivotTable,
    string $sourceField,
    string $foreignKey,
    string $relatedKey,
    $value
  ): void {
    // Skip if empty
    if (empty($value)) {
      return;
    }

    // Split the comma-separated IDs
    $relatedIds = !is_array($value) ? array_filter(array_map('trim', explode(',', $value))) : $value;

    // Skip if no IDs to process
    if (empty($relatedIds)) {
      return;
    }

    // Build the pivot records
    $pivotRecords = [];
    foreach ($relatedIds as $relatedId) {
      $pivotRecords[] = [
        $foreignKey => $sourceId,
        $relatedKey => $relatedId,
        'created_at' => now(),
        'updated_at' => now(),
      ];
    }

    // Insert the pivot records
    DB::connection($this->targetConnection)
      ->table($pivotTable)
      ->insertOrIgnore($pivotRecords);

    $this->logDebug("Inserted " . count($pivotRecords) . " pivot records for $sourceTable ID $sourceId");
  }

  protected function logDebug(string $message): void
  {
    if ($this->debug) {
      echo "[DEBUG] " . $message . PHP_EOL;
    }

    Log::debug("[MigrateFromCI] " . $message);
  }
}
