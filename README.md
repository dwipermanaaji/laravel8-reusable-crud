# Laravel 9 - Reusable CRUD
deskripsi
### Requirements
    PHP >= 7.4
    
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
perintah akan mengenerate `Pembuatan permission 'siswa-smk', Controller, Model, Migration, view form, dan menambahkan route` 

Catatan Opsi:
- --fields : menambahkan field di form, model, dan migrasi.
- --route : mengenerate route di web.php di folder route.
- --view-path : mengcustom folder view.
- --auth-name : membuat permission nama.list,create,read,update,destroy.
- --example : nanti akan menampilkan contoh di setiap file dengan komentar

### Supported Field Types

Contoh tipe data fieldsuntuk migration dan form.balde.php:

* string
* char
* varchar
* password
* email
* date
* datetime
* time
* timestamp
* text
* mediumtext
* longtext
* json
* jsonb
* binary
* number
* integer
* bigint
* mediumint
* tinyint
* smallint
* boolean
* decimal
* double
* float


### Generate Crud Dengan Perintah Manual
Pastikan sudah membuat migrasi, atau bisa dengan perintah laravel seperti
```bash
$ php artisan make:migration siswa
```

lalu membuat file **Siswa.php** di folder Models, sperti contoh berikut
```
    <?php

    namespace App\Models;

    use Illuminate\Database\Eloquent\Model;
    use App\Models\Resource;


    class Siswa extends Resource
    {
        protected $table = 'siswas';

        protected $fillable = ['nip', 'nama'];
    }
```
*catatan:
 - extends Model diganti dengan Reource
 - fillable harus di isi

lalu buat file **SiswaController.php** di folder controllers, seperti contoh berikut:
```
    <?php

    namespace App\Http\Controllers;

    use App\Http\Requests;
    use App\Http\Controllers\Controller;
    use App\Http\Controllers\BaseComponent\BaseController;

    class SiswaController extends BaseController
    {
        protected $f_model = 'Siswa';
        protected $title = 'Siswa';
        protected $route = 'siswa';        
    }

```
*catatan:
 - extends Controller diganti dengan BaseController
 - varibale **$f_model**, **$tile**, **$route** wajib di isi


