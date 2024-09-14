# how to install?
Run This command to install everything
```sh
composer install
php artisan migrate:fresh
```

# Testing out

# Migration
Run this command to migrate
```sh
php artisan migrate:fresh
```

# DB Seeding
Run this command to seed
```sh
php artisan db:seed --class=BookSeeder
```

```sh
php artisan db:seed --class=MemberSeeder
```
# API Documentation
Run This command
```sh
php artisan l5-swagger:generate
```