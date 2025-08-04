<?php

use App\Http\Controllers\MovieController;
use App\Http\Controllers\PeopleController;
use App\Http\Controllers\SearchController;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {
    Route::get('/search', [SearchController::class, 'search']);
    Route::get('/people/{id}', [PeopleController::class, 'getById']);
    Route::get('/movies/{id}', [MovieController::class, 'getById']);
    Route::get('/statistics', function () {
        return response()->json(Cache::get('statistics', []));
    });

});
