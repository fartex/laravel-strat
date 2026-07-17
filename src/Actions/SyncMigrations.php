<?php

namespace Fartex\Strat\Actions;

use Fartex\Strat\Enum\MigrationStatusEnum;
use Fartex\Strat\Enum\MigrationTypeEnum;
use Illuminate\Database\Migrations\Migrator;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

use function Illuminate\Support\enum_value;

class SyncMigrations
{
    /**
     * The migration files.
     */
    private array $migrationFiles;

    /**
     * Create a new action instance.
     */
    public function __construct(
        private readonly Migrator $migrator
    ) {
        $this->migrationFiles = $this->migrationFiles();
    }

    /**
     * Execute the action.
     */
    public function handle(): void
    {
        if (blank($this->migrationFiles)) {
            return;
        }

        $migrationRows = $this->buildMigrationRows();

        $this->createStratMigrationData($migrationRows);
    }

    /**
     * Build the migration rows.
     */
    private function buildMigrationRows(): array
    {
        // Get the migrations that have already been run, and the batch each one ran in
        $ran = $this->migrator->getRepository()->getRan();
        $batches = $this->migrator->getRepository()->getMigrationBatches();

        return collect($this->migrationFiles)->map(function (string $path, string $name) use ($ran, $batches) {
            $source = file_get_contents($path);

            return [
                'migration' => $name,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'table' => $this->resolveTable($name),
                'type' => $this->resolveType($source),
                'connection' => $this->resolveConnection($source),
                'status' => $this->getMigrationStatus($name, $ran),
                'batch' => $batches[$name] ?? null,
            ];
        })
            ->values()
            ->all();
    }

    /**
     * Get every host migration file, keyed by migration name, excluding the package's own.
     */
    private function migrationFiles(): array
    {
        $ownPath = realpath(__DIR__.'/../../database/migrations');

        $paths = array_filter(
            $this->migrator->paths(),
            fn (string $path) => realpath($path) !== $ownPath,
        );

        $paths[] = database_path('migrations');

        return $this->migrator->getMigrationFiles($paths);
    }

    /**
     * Read the migration's $connection property straight from its source, avoiding
     * having to require/instantiate a file the real Migrator may already have loaded.
     */
    private function resolveConnection(string $source): string
    {
        if (! Str::contains($source, '$connection')) {
            return config('database.default');
        }

        $connection = Str::of($source)
            ->after('$connection')
            ->after('=')
            ->before(';')
            ->trim(" \t\n\r\0\x0B'\"")
            ->toString();

        return blank($connection) ? config('database.default') : $connection;
    }

    /**
     * Derive the table name from the migration name, e.g.
     * "0001_01_01_000001_testbench_create_cache_table" becomes "testbench_create_cache".
     */
    private function resolveTable(string $name): string
    {
        $description = implode('_', array_slice(explode('_', $name), 4));

        return Str::endsWith($description, '_table')
            ? Str::beforeLast($description, '_table')
            : $description;
    }

    /**
     * Infer the schema operation by inspecting the migration's source.
     */
    private function resolveType(string $source): string
    {
        $type = Str::of($source)
            ->after('Schema::')
            ->before('(')
            ->trim()
            ->toString();

        return enum_value(match ($type) {
            'table' => MigrationTypeEnum::ALTER,
            'create' => MigrationTypeEnum::CREATE,
            'rename' => MigrationTypeEnum::RENAME,
            'drop', 'dropIfExists' => MigrationTypeEnum::DROP,
            default => MigrationTypeEnum::UNKNOWN,
        });
    }

    /**
     * Get the migration status based on whether it's already been run.'
     */
    private function getMigrationStatus(string $name, array $ran): string
    {
        return enum_value((in_array($name, $ran)
            ? MigrationStatusEnum::EXECUTED
            : MigrationStatusEnum::PENDING)
        );
    }

    /**
     * Create the migration data in the database.
     */
    private function createStratMigrationData(array $rows): void
    {
        DB::table('strat_migrations')->upsert(
            $rows,
            ['migration'],
            [
                'table',
                'type',
                'status',
                'batch',
                'updated_at',
                'connection',
            ]);
    }
}
