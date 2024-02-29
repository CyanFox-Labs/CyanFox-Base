<?php

namespace App\Livewire\Installer;

use Exception;
use Illuminate\Support\Facades\Artisan;
use Jackiedo\DotenvEditor\Facades\DotenvEditor;
use Livewire\Component;
use PDO;

class DatabaseSettings extends Component
{
    public $alert;

    public $host;

    public $port;

    public $database;

    public $username;

    public $password;

    public function testConnection(): bool
    {
        try {
            $connection = new PDO("mysql:host={$this->host};port={$this->port};dbname={$this->database}", $this->username, $this->password);
            $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $this->alert = [
                'title' => __('installer.database.alerts.success.title'),
                'type' => 'success',
                'message' => __('installer.database.alerts.success.message'),
            ];

            return true;
        } catch (Exception $e) {
            $this->alert = [
                'title' => __('installer.database.alerts.error.title'),
                'type' => 'error',
                'message' => $e->getMessage(),
            ];

            return false;
        }

    }

    public function saveDatabaseSettings(): void
    {
        $this->validate([
            'host' => 'required',
            'port' => 'required',
            'database' => 'required',
            'username' => 'required',
            'password' => 'required',
        ]);

        if (!$this->testConnection()) {
            return;
        }

        DotenvEditor::setKey('DB_HOST', $this->host);
        DotenvEditor::setKey('DB_PORT', $this->port);
        DotenvEditor::setKey('DB_DATABASE', $this->database);
        DotenvEditor::setKey('DB_USERNAME', $this->username);
        DotenvEditor::setKey('DB_PASSWORD', $this->password);
        DotenvEditor::save();

        try {
            Artisan::call('migrate', ['--force' => true]);
        } catch (Exception) {
        }

        $this->dispatch('changeStep', 'system');

    }

    public function mount()
    {
        $this->host = config('database.connections.mysql.host');
        $this->port = config('database.connections.mysql.port');
        $this->database = config('database.connections.mysql.database');
        $this->username = config('database.connections.mysql.username');
        $this->password = config('database.connections.mysql.password');
    }

    public function render()
    {
        return view('livewire.installer.database-settings');
    }
}
