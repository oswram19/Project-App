<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\Admin\HomeController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\DatatableController;

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

/*
codigo anterior de inicio de la aplicacion
Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});
 */

// Ruta raíz - redirige al dashboard si está autenticado, sino a login
Route::get('/', function () {
    if (auth()->check()) {
        return redirect()->route('dashboard');
    }
    return redirect()->route('login');
})->name('home');

//middleware de autenticacion y verificacion de usuario
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');


    Route::get('datatable/users', [DatatableController::class, 'user'])->name('datatable.user'); //se agrega ruta index para ajax datatable

    Route::resource('posts', PostController::class)->names('posts.index'); //se agrega names para nombrar la ruta index
    Route::get('/posts/{post}', [PostController::class, 'show'])->name('posts.show'); //se agrega ruta show
    Route::get('/posts/create', [PostController::class, 'create'])->name('posts.create'); //se agrega ruta create
    Route::post('/posts', [PostController::class, 'store'])->name('posts.store'); //se agrega ruta store
    Route::get('/posts/{post}/edit', [PostController::class, 'edit'])->name('posts.edit'); //se agrega ruta edit
    Route::put('/posts/{post}', [PostController::class, 'update'])->name('posts.update'); //se agrega ruta update
    Route::delete('/posts/{post}', [PostController::class, 'destroy'])->name('posts.destroy'); //se agrega ruta destroy

});
