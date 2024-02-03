<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Storage;

class DeleteTempDir extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'c:delete-temp';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Deletes the /storage/app/public/tmp directory.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Deleting /storage/app/public/tmp directory...');
        Storage::deleteDirectory('public/tmp');
        $this->info('The /storage/app/public/tmp directory has been deleted.');
    }
}
