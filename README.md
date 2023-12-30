# Laravel-Template

## Installation

1. Clone the repository
2. Run `composer update`
3. Run `npm install`
4. Run `npm run build`
5. Copy `.env.example` to `.env`
6. Set the permissions `sudo chgrp -R www-data . && sudo chmod -R 775 ./storage`
7. Run `php artisan key:generate` to generate an application key
8. Run `php artisan storage:link` to create a symbolic link to the storage directory
9. Run `php artisan cf:db-setup` to set the database credentials
10. Run `php artisan migrate` to create the database tables
11. Run `php artisan cf:create-permissions` to create the permissions
12. Run `php artisan cf:create-user` to create a user

## Development

View files are located in `resources/views/`.

LiveWire components are located in `app/Livewire/`.
