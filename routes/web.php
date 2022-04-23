<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/',[UserController::class, 'index'])->name('home');
Route::post('edit',[UserController::class, 'edit'])->name('edit');
Route::post('get-states-by-country', [UserController::class, 'getState'])->name('getState');
Route::post('get-cities-by-state', [UserController::class, 'getCity'])->name('getCity');

