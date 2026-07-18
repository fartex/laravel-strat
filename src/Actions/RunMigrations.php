<?php

namespace Fartex\Strat\Actions;

use Illuminate\Database\Migrations\Migrator;
use Illuminate\Support\Facades\DB;

class RunMigrations
{
    /**
     * The migration paths, excluding the package's own.
     */
    private array $paths;

    /**
     * Create a new action instance.
     */
    public function __construct(
        private readonly Migrator $migrator
    ) {
        $this->paths = $this->paths();
    }

    /**
     * Execute the action. Runs a single migration by id, or every pending
     * migration when no id is given.
     */
    public function handle(?int $id = null): void
    {
        if ($id === null) {
            $this->migrator->run($this->paths);

            return;
        }

        $this->runSingle($id);
    }

    /**
     * Run a single migration, identified by its strat_migrations id.
     */
    private function runSingle(int $id): void
    {
        $name = DB::table('strat_migrations')->where('id', $id)->value('migration');

        if (blank($name)) {
            return;
        }

        $path = data_get($this->migrator->getMigrationFiles($this->paths), $name) ?? null;

        if ($path === null || in_array($name, $this->migrator->getRepository()->getRan())) {
            return;
        }

        $this->migrator->runPending([$path]);
    }

    /**
     * Get every host migration path, excluding the package's own.
     */
    private function paths(): array
    {
        $ownPath = realpath(__DIR__.'/../../database/migrations');

        $paths = array_filter(
            $this->migrator->paths(),
            fn (string $path) => realpath($path) !== $ownPath,
        );

        $paths[] = database_path('migrations');

        return $paths;
    }
}
