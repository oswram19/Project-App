<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use \App\Mail\ContactanosMailable;
use App\Http\Controllers\Admin\HomeController;
use App\Http\Controllers\ContactanosController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\DatatableController;
use Illuminate\Support\Facades\Mail;

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


    Route::get('datatable/users', [DatatableController::class, 'user'])->name('datatable.user');
    Route::get('datatable/categories', [DatatableController::class, 'category'])->name('datatable.category');


    //se acortaron las rutas del controlador de posts
    Route::resource('posts', PostController::class)->names('posts');

    //*********prueba de envio de correo*******************
    /* Route::get('contactanos', function () {

        Mail::to('oswaldo@ozmag.com')
            ->send(new ContactanosMailable);

        return "Correo enviado correctamente";
    })->name('contactanos');

    */

    Route::get('contactano', [ContactanosController::class, 'index'])->name('contactanos.index');
    Route::post('contactano', [ContactanosController::class, 'store'])->name('contactanos.store');


    // Rutas anteriores individuales (ahora manejadas por Route::resource)
    // Route::get('/posts/{post}', [PostController::class, 'show'])->name('posts.show');
    // Route::get('/posts/create', [PostController::class, 'create'])->name('posts.create');
    // Route::post('/posts', [PostController::class, 'store'])->name('posts.store');
    // Route::get('/posts/{post}/edit', [PostController::class, 'edit'])->name('posts.edit');
    // Route::put('/posts/{post}', [PostController::class, 'update'])->name('posts.update');
    // Route::delete('/posts/{post}', [PostController::class, 'destroy'])->name('posts.destroy');

});
