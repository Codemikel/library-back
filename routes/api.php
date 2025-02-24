<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\v1\BookController;
use App\Http\Controllers\Api\v1\LoanController;
use App\Http\Controllers\Api\v1\AuthorController;
use App\Http\Controllers\Api\v1\GenreController;
use App\Http\Controllers\Api\v1\UserController;


Route::apiResource('/v1/libros', BookController::class);

Route::apiResource('/v1/prestamos', LoanController::class);

Route::apiResource('/v1/autores', AuthorController::class);

Route::apiResource('/v1/generos', GenreController::class);

Route::apiResource('/v1/usuarios', UserController::class);
