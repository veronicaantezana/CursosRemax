<?php

use App\Http\Controllers\Curso\CourseController;
use Illuminate\Support\Facades\Route;

Route::group([
    'prefix' => 'cursos',
    'as' => 'cursos.'
], function () {
    Route::get('/', [CourseController::class, 'index'])->name('index');
    Route::get('/buscar', [CourseController::class, 'buscar'])->name('buscar');
    Route::get('/{id}', [CourseController::class, 'show'])->name('show');
});