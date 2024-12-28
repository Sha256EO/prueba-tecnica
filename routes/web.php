<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Users;
use App\Http\Controllers\Event;

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

//Route::get('/', function () {
//    return view('welcome');
//});

// Rutas para el usuario
Route::get('/', [Users::class, 'index'])->name('index');

// Rutas para los eventos

Route::get('/create', [Event::class, 'create'])->name('create');
Route::post('/store', [Event::class, 'store'])->name('store');
