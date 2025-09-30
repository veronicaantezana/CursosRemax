<?php

use App\Http\Controllers\Admin\Categoria\CategoryController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;


Route::group([
    'prefix' => 'admin',
    'as' => 'admin.',
    'middleware' => ['auth']
], function () {
    Route::get('/dashboard', function () {
        // Verificar si es admin usando el modelo User de Laravel
          if (!Auth::user() || Auth::user()->role_id !== 2) {
            return redirect('/');
        }
        return Inertia::render('Admin/Dashboard', [
             'user' => Auth::user()
        ]);
    })->name('dashboard');
    //categorias
    Route::get('/categorias', [CategoryController::class, 'index'])->name('categories.index');
    Route::get('/categorias/crear', function () {
         if (!Auth::user() || Auth::user()->role_id !== 2) {
            return redirect('/');
        }
        return app(CategoryController::class)->create();
    })->name('categories.create');

    Route::post('/categorias', [CategoryController::class, 'store'])->name('categories.store');
    Route::get('/categorias/{id}/editar', [CategoryController::class, 'edit'])->name('categories.edit');
    Route::post('/categorias/{id}', [CategoryController::class, 'update'])->name('categories.update');
    Route::delete('/categorias/{id}', [CategoryController::class, 'destroy'])->name('categories.destroy');
});
