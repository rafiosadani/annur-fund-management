<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('welcome');
});

// route authentication - can't be accessed yet
Route::get('/login', function () {
    return view('auth.login');
});

Route::get('/register', function () {
    return view('auth.register');
});

// route dashboard
Route::get('/dashboard', function () {
    return view('dashboard.index');
})->name('dashboard');

// route master data
// route charitable donations
Route::get('/master/charitable-donations', function () {
    return view('dashboard.charitable-donations.index');
})->name('charitable-donations.index');
