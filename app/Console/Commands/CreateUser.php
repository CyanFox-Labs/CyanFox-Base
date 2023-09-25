<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use function Laravel\Prompts\password;
use function Laravel\Prompts\text;

class CreateUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:user';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new User';

    /**
     * Execute the console command.
     */
    public function handle()
    {

        $username = text('What is the username?');
        $email = text('What is the email?');
        $password = password('What is the password?');

        $user = new User();
        $user->username = $username;
        $user->email = $email;
        $user->password = bcrypt($password);

        if ($user->save()) {
            $this->info('User created successfully.');
        } else {
            $this->error('User could not be created.');
        }

    }
}
