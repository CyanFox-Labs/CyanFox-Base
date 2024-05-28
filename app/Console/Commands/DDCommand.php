<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class DDCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'dd {code*}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'dd your code.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        return collect($this->argument('code'))
            ->map(function (string $command) {
                return rtrim($command, ';');
            })
            ->map(function (string $sanitizedCommand) {
                return eval("dump({$sanitizedCommand});");
            })
            ->implode(PHP_EOL);
    }
}
