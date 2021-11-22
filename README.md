# Laravel 9 - Reusable CRUD
deskripsi
### Requirements
    Laravel >=5.1
    PHP >= 5.5.9
    
## New project
```bash
$ git clone git@gitlab.com:sagara-xinix/framework/sagara-laravel.git
```

Catatan: Jangan lupa hapus git
```bash
laravel-project
$ rm -rf .git
```

### Config Project
```$ cp .env.example .env```
lalu sesuaikan `.env` dengan sistem php yang digunakan

```bash
$ composer install
$ php artisan key:generate
$ php artisan migrate --seed
```
