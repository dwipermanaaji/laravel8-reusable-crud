<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Examples\ExampleFormController;
use App\Http\Controllers\Pengaturan\RoleController;
use App\Http\Controllers\Pengaturan\RolePermission\ModulePermissionController;
use App\Http\Controllers\Pengaturan\RolePermission\PermissionController;
use App\Http\Controllers\Pengaturan\RolePermission\SubModulePermissionController;
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

        Route::get('module-permission/datatable',[ModulePermissionController::class,'dataTable'])->name('pengaturan.module-permission.datatable');
        Route::get('module-permission/trash', [ModulePermissionController::class, 'trash'])->name('pengaturan.module-permission.trash');
        Route::post('module-permission/{id}/restore', [ModulePermissionController::class, 'restore'])->name('pengaturan.module-permission.restore');
        Route::delete('module-permission/{id}/delete', [ModulePermissionController::class, 'delete'])->name('pengaturan.module-permission.delete');
        Route::resource('module-permission', ModulePermissionController::class, ['as'=>'pengaturan']);

        Route::get('sub-module-permission/datatable',[SubModulePermissionController::class,'dataTable'])->name('pengaturan.sub-module-permission.datatable');
        Route::get('sub-module-permission/trash', [SubModulePermissionController::class, 'trash'])->name('pengaturan.sub-module-permission.trash');
        Route::post('sub-module-permission/{id}/restore', [SubModulePermissionController::class, 'restore'])->name('pengaturan.sub-module-permission.restore');
        Route::delete('sub-module-permission/{id}/delete', [SubModulePermissionController::class, 'delete'])->name('pengaturan.sub-module-permission.delete');
        Route::resource('sub-module-permission', SubModulePermissionController::class,['as'=>'pengaturan']);
        
        Route::get('permission/datatable',[PermissionController::class,'dataTable'])->name('pengaturan.permission.datatable');
        Route::resource('permission', PermissionController::class,['as'=>'pengaturan']);
    
    });

    Route::get('examples-crud/datatable',[ExampleFormController::class,'dataTable'])->name('examples-crud.datatable');
    Route::get('examples-crud/trash', [ExampleFormController::class, 'trash'])->name('examples-crud.trash');
    Route::post('examples-crud/{id}/restore', [ExampleFormController::class, 'restore'])->name('examples-crud.restore');
    Route::delete('examples-crud/{id}/delete', [ExampleFormController::class, 'delete'])->name('examples-crud.delete');
    Route::resource('examples-crud', ExampleFormController::class);
});

Route::group(['middleware' => ['auth:sanctum', 'verified']], function () {
});