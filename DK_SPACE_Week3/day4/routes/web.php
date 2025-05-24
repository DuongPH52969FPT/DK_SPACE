<?php

use App\Http\Controllers\TestRelationController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});


Route::get('/Eloquent', [TestRelationController::class, 'index']);