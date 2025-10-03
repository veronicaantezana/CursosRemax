<?php

use App\Http\Controllers\Admin\Categoria\CategoryController;
use App\Http\Controllers\Admin\Curso\CursoController;
use App\Http\Controllers\Admin\Curso\TemaController;
use App\Http\Controllers\Admin\Curso\TestController;
use App\Http\Controllers\Admin\Curso\MaterialController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;


Route::group([
    'prefix' => 'admin',
    'as' => 'admin.',
    'middleware' => ['auth']
], function () {
    Route::get('/dashboard', function () {
        if (!Auth::user() || Auth::user()->role_id !== 2) {
            return redirect('/');
        }
        return Inertia::render('Admin/Dashboard', [
            'user' => Auth::user()
        ]);
    })->name('dashboard');
    
    // Categorías
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
    
    //Cursos
    Route::get('/cursos', [CursoController::class, 'index'])->name('cursos.index');
    Route::get('/cursos/crear', [CursoController::class, 'create'])->name('cursos.create');
    Route::post('/cursos', [CursoController::class, 'store'])->name('cursos.store');
    Route::get('/cursos/{id}/editar', [CursoController::class, 'edit'])->name('cursos.edit');
    Route::put('/cursos/{id}', [CursoController::class, 'update'])->name('cursos.update');
    Route::delete('/cursos/{id}', [CursoController::class, 'destroy'])->name('cursos.destroy');
    
    //temas
    Route::get('/cursos/{id}/temas/crear', [TemaController::class, 'create'])->name('temas.create');
    Route::get('/cursos/{id}/temas', [TemaController::class, 'index'])->name('temas.index');
    Route::post('/temas', [TemaController::class, 'store'])->name('temas.store');
    Route::get('/cursos/{curso}/temas/{tema}/editar', [TemaController::class, 'edit'])->name('temas.edit');
    Route::put('/cursos/{curso}/temas/{tema}', [TemaController::class, 'update'])->name('temas.update');
    Route::delete('/cursos/{curso}/temas/{tema}', [TemaController::class, 'destroy'])->name('temas.destroy');

    //test
    Route::get('/cursos/{curso}/tests/crear', [TestController::class, 'create'])->name('tests.create');
    Route::post('/cursos/{curso}/tests', [TestController::class, 'store'])->name('tests.store');
    Route::get('/cursos/{curso}/tests/{test}', [TestController::class, 'show'])->name('tests.show');
    Route::get('/cursos/{curso}/tests/{test}/editar', [TestController::class, 'edit'])->name('tests.edit');
});
