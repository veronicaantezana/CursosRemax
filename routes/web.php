<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Home');
});

Route::get('/buscar', function () {
    return Inertia::render('Buscar');
});

Route::get('/aprendizaje', function () {
    return Inertia::render('Aprendizaje');
});

Route::get('/guardados', function () {
    return Inertia::render('Guardados');
});


require __DIR__ . '/cursos.php';
require __DIR__ . '/admin.php';