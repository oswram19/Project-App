<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\HomeController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\TagController;
use App\Http\Controllers\Admin\PostController;
//se creo el prefijo en la ruta APP/PROVIDERS/ROUTESERVICEPROVIDER.PHP por eso se quita del 'admin',funtion()
//se paso al controlador HomeController

Route::get('',[HomeController::class,'index'])->name('admin.home');
//le decimos que solo agregue index,create,store,edit,update,destroy
Route::resource('users', UserController::class)->names('admin.users')->only(['index', 'create', 'store', 'edit', 'update', 'destroy']);
Route::resource('categories', CategoryController::class)->names('admin.categories');
Route::resource('tags', TagController::class)->names('admin.tags');
Route::resource('posts', PostController::class)->names('admin.posts');
