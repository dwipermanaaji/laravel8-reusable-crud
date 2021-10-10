<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Examples\ExampleFormController;
use App\Http\Controllers\Pengaturan\RoleController;
use App\Http\Controllers\Pengaturan\UserController;
use App\Http\Controllers\ResourcesController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return redirect('/dashboard');
});

Route::middleware(['auth:sanctum', 'verified'])->group(function () {
    Route::get('/dashboard',[DashboardController::class, 'index'])->name('dashboard');

    Route::prefix('/pengaturan')->group(function () {
        Route::resource('/user', UserController::class,['as'=>'pengaturan']);
        Route::resource('/role', RoleController::class,['as'=>'pengaturan']);
    });


    Route::prefix('/pengaturan')->group(function () {
        Route::resource('/user', UserController::class,['as'=>'pengaturan']);
        Route::resource('/role', RoleController::class,['as'=>'pengaturan']);
    });

    Route::resource('examples-crud', ExampleFormController::class);
    Route::get('datatable/examples-crud',[ ExampleFormController::class,'dataTable'])->name('examples-crud.datatable');

    //ResourcesController
    Route::get('{collection}',[ResourcesController::class, 'index'])->name('resources.index');
});


