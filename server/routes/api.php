<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PessoaController;

Route::post('/login', [UserController::class, 'login']);

Route::middleware('auth.token')->group(function () {
    Route::post('/users', [UserController::class, 'create']);
    Route::put('/users/{id}', [UserController::class, 'update']);

    Route::get('/pessoas', [PessoaController::class, 'list']);
    Route::get('/pessoas/{id}', [PessoaController::class, 'find']);
    Route::post('/pessoas', [PessoaController::class, 'create']);
    Route::put('/pessoas/{id}', [PessoaController::class, 'update']);
    Route::delete('/pessoas/{id}', [PessoaController::class, 'delete']);
});
