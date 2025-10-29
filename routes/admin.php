<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\HomeController;
//se creo el prefijo en la ruta APP/PROVIDERS/ROUTESERVICEPROVIDER.PHP por eso se quita del 'admin',funtion()
//se paso al controlador HomeController

Route::get('',[HomeController::class,'index'])->name('admin.home');
  