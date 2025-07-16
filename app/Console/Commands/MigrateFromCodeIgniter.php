<?php

namespace App\Console\Commands;

use App\Services\Migration\MigrationService;
use Illuminate\Console\Command;

class MigrateFromCodeIgniter extends Command
{
    protected $signature = 'migrate:from-ci {--chunk=1000} {--table=} {--start=0} {--debug}';

    protected $description = 'Migrate data from CodeIgniter database to Laravel';

    public function handle(MigrationService $migrationService): int
    {
        $this->info('Starting migration from CodeIgniter to Laravel...');

        // Get command options
        $options = [
            'chunkSize' => (int) $this->option('chunk'),
            'singleTable' => $this->option('table'),
            'startOffset' => (int) $this->option('start'),
            'debug' => (bool) $this->option('debug'),
        ];

        try {
            $migrationService->setOutput($this->output);
            $result = $migrationService->migrate($options);
            $this->info('Migration completed successfully!');

            return 0;
        } catch (\Exception $e) {
            $this->error('Migration failed: '.$e->getMessage());

            return 1;
        }
    }
}
