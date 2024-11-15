<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DonationController;
use App\Http\Controllers\FundraisingProgramController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RoleController;
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
})->name('login')->middleware('guest');

Route::get('/register', function () {
    return view('auth.register');
})->name('register')->middleware('guest');

Route::post('/login', [AuthController::class, 'authenticate'])->name('authenticate')->middleware('guest');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

Route::post('/register', [AuthController::class, 'register'])->name('register')->middleware('guest');

Route::middleware(['auth'])->group(function () {
    // route dashboard
    Route::get('/dashboard', function () { return view('dashboard.index'); })->name('dashboard');
    Route::post('/change-password', [AuthController::class, 'saveChangePassword'])->name('change-password');

    // master data
    Route::prefix('master')->group(function () {
        // route charitable donations
        Route::get('/charitable-donations', function () {
            return view('dashboard.charitable-donations.index');
        })->name('master.charitable-donations.index');

        // donations

        // fundraising programs
        Route::get('/fundraising-programs/restore/one/{id}', [FundraisingProgramController::class, 'restore'])->name('fundraising-programs.restore');
        Route::get('/fundraising-programs/restoreAll', [FundraisingProgramController::class, 'restoreAll'])->name('fundraising-programs.restore.all');
        Route::resource('/fundraising-programs', FundraisingProgramController::class);

        // roles
        Route::get('/roles/restore/one/{id}', [RoleController::class, 'restore'])->name('roles.restore');
        Route::get('/roles/restoreAll', [RoleController::class, 'restoreAll'])->name('roles.restore.all');
        Route::resource('/roles', RoleController::class);

        // users
        Route::get('/users/restore/one/{id}', [UserController::class, 'restore'])->name('users.restore');
        Route::get('/users/restoreAll', [UserController::class, 'restoreAll'])->name('users.restore.all');
        Route::resource('/users', UserController::class);
    });

    Route::prefix('transactions')->group(function () {
        // donation offline
        Route::get('/donations/donation-offline', [DonationController::class, 'listOfflineDonations'])->name('transaction.donations.offline-donation.index');
        Route::post('/donations/donation-offline', [DonationController::class, 'storeOfflineDonation'])->name('transaction.donations.offline-donation.store');
    });



    Route::post('/roles/restoreAll', [RoleController::class, 'restoreAll'])->name('roles.restore.all');
});



