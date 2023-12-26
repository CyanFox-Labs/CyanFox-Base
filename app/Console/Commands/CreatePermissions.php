<?php

namespace App\Console\Commands;

use Exception;
use Illuminate\Console\Command;
use Spatie\Permission\Models\Permission;

class CreatePermissions extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cf:create-permissions';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Creates all necessary permissions for the application';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $permissions = [];

        $error = false;

        foreach ($permissions as $permission) {
            try {
                Permission::create(['name' => $permission]);
            }catch (Exception $e) {
                $this->info('Could not create permission: ' . $permission);
                $this->error('Error: ' . $e->getMessage());
                $error = true;
            }
        }

        if (!$error) {
            $this->info('All permissions created successfully');
        }else {
            $this->error('Some permissions could not be created');
        }
    }
}
