<?php

namespace App\Services\Migration;

use App\Services\Migration\Transformers\TransformerFactory;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Symfony\Component\Console\Output\OutputInterface;

class MigrationService
{
    protected $mappingConfig;

    protected $transformerFactory;

    protected $sourceConnection;

    protected $targetConnection;

    protected $output;

    public function __construct(
        MappingConfig $mappingConfig,
        TransformerFactory $transformerFactory
    ) {
        $this->mappingConfig = $mappingConfig;
        $this->transformerFactory = $transformerFactory;
        $this->sourceConnection = config('database.ci_migration.source', 'codeigniter');
        $this->targetConnection = config('database.ci_migration.target', 'mysql');
    }

    public function setOutput(OutputInterface $output): void
    {
        $this->output = $output;
    }

    public function migrate(array $options): bool
    {
        $tableMappings = $this->mappingConfig->getTableMappings();
        $fieldMappings = $this->mappingConfig->getFieldMappings();

        $chunkSize = $options['chunkSize'];
        $singleTable = $options['singleTable'];
        $startOffset = $options['startOffset'];

        // Filter tables if a specific one is requested
        if ($singleTable) {
            if (! isset($tableMappings[$singleTable])) {
                throw new \InvalidArgumentException("Table {$singleTable} not found in mappings");
            }
            $tablesToProcess = [$singleTable => $tableMappings[$singleTable]];
        } else {
            $tablesToProcess = $tableMappings;
        }

        foreach ($tablesToProcess as $sourceTable => $targetTables) {
            // Convert single target tables to array for consistent processing
            if (! is_array($targetTables)) {
                $targetTables = [$targetTables];
            }

            $this->info("Migrating table {$sourceTable} to ".implode(', ', $targetTables));

            // Count total records
            $totalRecords = DB::connection($this->sourceConnection)
                ->table($sourceTable)
                ->count();

            $this->info("Found {$totalRecords} records to migrate");

            // Process in chunks to avoid memory issues
            $counter = 0;
            DB::connection($this->sourceConnection)
                ->table($sourceTable)
                ->orderBy('id')
                ->when($startOffset > 0, function ($query) use ($startOffset) {
                    return $query->where('id', '>=', $startOffset);
                })
                ->chunk($chunkSize, function ($records) use ($sourceTable, $targetTables, $fieldMappings, &$counter, $totalRecords, $options) {
                    $processor = new ChunkProcessor(
                        $this->transformerFactory,
                        $this->sourceConnection,
                        $this->targetConnection,
                        $options['debug']
                    );

                    $processor->process($records, $sourceTable, $targetTables, $fieldMappings);

                    $counter += count($records);
                    $this->info("Migrated {$counter} of {$totalRecords} records");
                });

            $this->info("Completed migration for table {$sourceTable}: {$counter} records processed");
        }

        return true;
    }

    protected function info(string $message): void
    {
        if ($this->output) {
            $this->output->writeln($message);
        }

        Log::info('[MigrationService] '.$message);
    }
}
