# Laravel 9 - Reusable CRUD
deskripsi
### Requirements
    Laravel >=5.1
    PHP >= 5.5.9
    
## New project
```bash
$ git clone https://github.com/dwipermanaaji/laravel8-reusable-crud.git
```

Catatan: Jangan lupa hapus folder .git 
```bash
laravel-project
$ rm -rf .git
```

### Config Project
```bash 
    $ cd laravel8-reusable-crud/
    $ cp .env.example .env
```
lalu sesuaikan `.env` dengan sistem php yang digunakan

```bash
$ composer install
$ php artisan key:generate
$ php artisan migrate --seed
$ php artisan serve
```

Catatan: Email & Password root
```bash
email: admin@admin.com
password: admin
```
