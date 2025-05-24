<?php

use App\Http\Controllers\CandidateController;
use Illuminate\Support\Facades\Route;
use Symfony\Component\Routing\RouterInterface;

Route::get('/', function () {
    return view('welcome');
});


// Route::resource('candidate')->group(function () {
//    Route::get('/create', [CandidateController::class, 'create']);

// });

Route::resource('candidate', CandidateController::class);