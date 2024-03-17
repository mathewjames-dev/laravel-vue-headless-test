<?php

use App\Http\Controllers\Api\LoginController;
use App\Http\Controllers\Api\UsersController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

/**
 * Authentication Routes
 *
 * I would obviously in a real world application, have a proper authentication (register, login, logout, etc.) system in place. And use sanctum or passport for API authentication.
 */
Route::post('/login', [LoginController::class, 'login']);

/**
 * User Routes
 */
Route::get('/users', [UsersController::class, 'index'])->middleware('token');
Route::post('/users/create', [UsersController::class, 'store'])->middleware('token');
Route::post('/users/{user}/update', [UsersController::class, 'update'])->middleware('token');
Route::delete('/users/{user}/delete', [UsersController::class, 'destroy'])->middleware('token');
