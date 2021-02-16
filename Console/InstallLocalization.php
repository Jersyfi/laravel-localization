<?php

namespace Jersyfi\Localization\Console;

use Illuminate\Console\Command;

class InstallLocalization extends Command
{
    /**
     * Signature for installing command
     */
    protected $signature = 'localization:install';

    /**
     * Description for installing command
     */
    protected $description = 'Install the Localization';

    /**
     * Handle the install command
     */
    public function handle()
    {
        $this->info('Installing Localization...');

        $this->info('Publishing configuration...');

        $this->call('vendor:publish', [
            '--provider' => "Jersyfi\Localization\LocalizationServiceProvider",
            '--tag' => "config"
        ]);

        $this->info('Installed Localization');
    }
}
