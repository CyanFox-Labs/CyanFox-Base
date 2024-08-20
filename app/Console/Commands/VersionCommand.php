<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class VersionCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'version';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Get the current version of the Laravel application.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Laravel version: ' . $this->getLaravel()->version());
        $this->info('PHP version: ' . PHP_VERSION);
        $this->info('Template version: ' . version()->getCurrentTemplateVersion());
        $this->info('Project version: ' . version()->getCurrentProjectVersion());
        $this->info('Development version: ' . (version()->isDevVersion() ? 'Yes' : 'No'));
    }
}
