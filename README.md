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

*Catatan: Email & Password root
```
email: admin@admin.com
password: admin
```

### Generate Crud Dengan Perintah PHP ARTISAN
```bash
$ php artisan dcrud:generate Siswa --fields="nip:text, nama"
```
perintah akan mengenerate `Controller,Model,Migration` 

lalu sesuaikan file migrasi apa sudah benar atau belum, lalu:
```bash
$ php artisan migrate
```

buka file `web.php` di folder route, lalu buat route sepereti:
`
Route::get('siswa/datatable',[SiswaController::class,'dataTable'])->name('siswa.datatable');
Route::get('siswa/trash', [SiswaController::class, 'trash'])->name('siswa.trash');
Route::post('siswa/{id}/restore', [SiswaController::class, 'restore'])->name('siswa.restore');
Route::delete('siswa/{id}/delete', [SiswaController::class, 'delete'])->name('siswa.delete');
Route::resource('siswa', SiswaController::class);
`
jangan lupa untuk memangil SiswaController `use App\Http\Controllers\SiswaController;`



