<?php

namespace App\Console\Commands;

use Exception;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Jackiedo\DotenvEditor\Facades\DotenvEditor;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use function Laravel\Prompts\confirm;
use function Laravel\Prompts\password;
use function Laravel\Prompts\text;

class DataBaseSetup extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cf:db-setup';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Set up the database';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $host = text('What is the database host?', '127.0.0.1', '127.0.0.1');
        $port = text('What is the database port?', '3306', '3306');
        $database = text('What is the database name?');
        $username = text('What is the database username?');
        $password = password('What is the database password?');

        $this->info('Writing to .env file...');
        DotenvEditor::setKey('DB_HOST', $host);
        DotenvEditor::setKey('DB_PORT', $port);
        DotenvEditor::setKey('DB_DATABASE', $database);
        DotenvEditor::setKey('DB_USERNAME', $username);
        DotenvEditor::setKey('DB_PASSWORD', $password);
        DotenvEditor::save();

        $this->info('Environment variables set!');

        $migrate = confirm('Do you want to migrate the database?');
        if ($migrate) {
            $this->info('Migrating database...');
            $this->call('migrate');
            $this->info('Database migrated!');

            $roles = ['Super Admin'];

            foreach ($roles as $role) {
                try {
                    Role::create(['name' => $role]);
                }catch (Exception $e) {
                    $this->info('Could not create role: ' . $role);
                    $this->error('Error: ' . $e->getMessage());
                }
            }
        }
    }
}
