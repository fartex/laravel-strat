<?php

namespace Fartex\Strat\Console\Commands;

use App\Providers\StratServiceProvider;
use Illuminate\Console\Command;
use Illuminate\Support\ServiceProvider;

class BootstrapCommand extends Command
{
    /**
     * The name and signature of the console command.
     */
    protected $signature = 'strat:install';

    /**
     * The console command description.
     */
    protected $description = 'Install Strat: publish its config, assets and service provider, then run its migrations.';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $this->call('vendor:publish', ['--tag' => 'strat-config']);
        $this->call('vendor:publish', ['--tag' => 'strat-assets']);
        $this->call('vendor:publish', ['--tag' => 'strat-provider']);

        ServiceProvider::addProviderToBootstrapFile(StratServiceProvider::class);

        if ($this->components->confirm('Run the Strat migrations now?', true)) {
            $this->call('migrate');
        }

        $this->components->info('Strat installed successfully!');

        return self::SUCCESS;
    }
}
