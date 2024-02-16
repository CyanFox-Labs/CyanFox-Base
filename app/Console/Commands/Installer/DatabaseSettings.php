<?php

namespace App\Console\Commands\Installer;

use Exception;
use Illuminate\Console\Command;
use Jackiedo\DotenvEditor\Facades\DotenvEditor;
use PDO;
use function Laravel\Prompts\confirm;
use function Laravel\Prompts\password;
use function Laravel\Prompts\text;

class DatabaseSettings extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'c:installer:db';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Set the database settings for the application.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $host = text('Database Host', config('database.connections.mysql.host'), config('database.connections.mysql.host'), required: true);
        $port = text('Database Port', config('database.connections.mysql.port'), config('database.connections.mysql.port'), required: true);
        $database = text('Database Name', config('database.connections.mysql.database'), config('database.connections.mysql.database'), required: true);
        $username = text('Database Username', config('database.connections.mysql.username'), config('database.connections.mysql.username'), required: true);
        $password = password('Database Password', config('database.connections.mysql.password'), required: true);

        if ($this->testConnection($host, $port, $database, $username, $password)) {

            DotenvEditor::setKey('DB_HOST', $host);
            DotenvEditor::setKey('DB_PORT', $port);
            DotenvEditor::setKey('DB_DATABASE', $database);
            DotenvEditor::setKey('DB_USERNAME', $username);
            DotenvEditor::setKey('DB_PASSWORD', $password);
            DotenvEditor::save();

            $this->info('Database connection successful.');
        } else {
            $this->error('Database connection failed.');
            $this->handle();
        }

        $this->info('Database settings saved.');

        $migrate = confirm('Would you like to run the migrations now?', true);
        if ($migrate) {
            try {
                $this->call('migrate');
            }catch (Exception $e) {
                $this->warn('Database migration failed.');
                $this->warn($e->getMessage());
            }
        }

        $this->info('Database setup complete.');

        $continue = confirm('Would you like to continue with the installation?', true);
        if ($continue) {
            $this->call('c:installer:system');
        }

    }

    public function testConnection($host, $port, $database, $username, $password)
    {
        try {
            $connection = new PDO("mysql:host={$host};port={$port};dbname={$database}", $username, $password);
            $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return true;
        } catch (\Exception $e) {
            return false;
        }

    }
}
