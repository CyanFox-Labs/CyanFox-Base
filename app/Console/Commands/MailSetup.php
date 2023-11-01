<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Jackiedo\DotenvEditor\Facades\DotenvEditor;
use function Laravel\Prompts\password;
use function Laravel\Prompts\text;

class MailSetup extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cf:mail-setup';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Set up mail settings';

    /**
     * Execute the console command.
     */
    public function handle()
    {

        $mailer = text('What mailer do you want to use?', 'smtp');
        $host = text('What is the Mail Host?', 'smtp.mailtrap.io');
        $port = text('What is the Mail Port?');
        $username = text('What is the Mail Username?');
        $password = password('What is the Mail Password?');
        $encryption = text('What is the Mail Encryption?');
        $from_address = text('What is the Mail From Address?');

        $this->info('Writing to .env file...');
        DotenvEditor::setKey('MAIL_MAILER', $mailer);
        DotenvEditor::setKey('MAIL_HOST', $host);
        DotenvEditor::setKey('MAIL_PORT', $port);
        DotenvEditor::setKey('MAIL_USERNAME', $username);
        DotenvEditor::setKey('MAIL_PASSWORD', $password);
        DotenvEditor::setKey('MAIL_ENCRYPTION', $encryption);
        DotenvEditor::setKey('MAIL_FROM_ADDRESS', $from_address);
        DotenvEditor::save();

        $this->info('Environment variables set!');
    }
}
