<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\Auth\LoginController;
use Illuminate\Support\Facades\Auth;

Route::get('/login', function () {
    if (Auth::check()) {
        return Auth::user()->role_id === 2 
            ? redirect('/admin/dashboard')
            : redirect('/');
    }
    return Inertia::render('Login');
})->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout']);

Route::middleware(['auth'])->group(function () {
    Route::get('/', function () {
        return Inertia::render('Home', [
           'user' => Auth::user()// ← Pasar usuario autenticado
        ]);
    });
    Route::get('/buscar', function () {
        return Inertia::render('Buscar', [
            'user' => Auth::user()
        ]);
    });

    Route::get('/aprendizaje', function () {
        return Inertia::render('Aprendizaje', [
            'user' => Auth::user()
        ]);
    });


    Route::get('/guardados', function () {
        return Inertia::render('Guardados', [
            'user' => Auth::user()
        ]);
    });
});

require __DIR__ . '/cursos.php';
require __DIR__ . '/admin.php';
