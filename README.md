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
```
Route::get('siswa/datatable',[SiswaController::class,'dataTable'])->name('siswa.datatable');
Route::resource('siswa', SiswaController::class);
```
jangan lupa untuk memangil SiswaController `use App\Http\Controllers\SiswaController;`

Kamu juga bisa dengan mudah memasukan route, mengcustom form di view, custom nama permission, dll, melalui opsi **--route**, **--form**, **--view-path=**, **--auth-name=** sperti contoh berikut:
```bash
$ php artisan dcrud:generate Siswa --fields="nip:text, nama" --route --form --view-path=master --auth-name=siswaSmk
```
perintah akan mengenerate `Pembyatan permission 'siswa-smk', Controller, Model, Migration, view form, dan menambahkan route` 
Catatan Opsi:
- --fields : menambahkan field di form, model, dan migrasi.
- --route : mengenerate route di web.php di folder route.
- --view-path : mengcustom folder view.
- --auth-name : membuat permission nama.list,create,read,update,destroy.
- --example : nanti akan menampilkan contoh di setiap file dengan komentar

selesai


### Generate Crud Dengan Perintah **tanpa** PHP ARTISAN

