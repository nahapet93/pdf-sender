<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\FileController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [FileController::class, 'index'])->name('home');
Route::post('/store', [FileController::class, 'store'])->name('files.store');
Route::post('/send', [FileController::class, 'send'])->name('files.send');

Route::resource('users', UserController::class)->only('index', 'store')
    ->name('index', 'users')
    ->name('store', 'users.store');
