<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', fn () => Inertia::render('Home'));
Route::get('/statistics', fn () => Inertia::render('Statistics'));
Route::get('/people/{id}', function (Request $request, $id) {
    return Inertia::render('People', [
        'id' => $id,
    ]);
});

Route::get('/movies/{id}', function (Request $request, $id) {
    return Inertia::render('Movies', [
        'id' => $id,
    ]);
});
