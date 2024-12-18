<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DonationController;
use App\Http\Controllers\DonorController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\FundraisingProgramController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\InfaqController;
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

Route::post('/register', [AuthController::class, 'register'])->name('registerUser')->middleware('guest');

Route::middleware(['web', 'auth'])->group(function () {
    // route dashboard
    Route::get('/dashboard', function () { return view('dashboard.index'); })->name('dashboard');

    // change password
    Route::post('/change-password', [AuthController::class, 'saveChangePassword'])->name('change-password');

    // profile and edit profile
        Route::get('/profile', [AuthController::class, 'profile'])->name('profile');
    Route::put('/profile/{id}/update/', [AuthController::class, 'updateProfile'])->name('profile.update')->middleware('prevent.get.for.put');

    // master data
    Route::prefix('master')->group(function () {
        // route charitable donations
        Route::get('/charitable-donations', function () {
            return view('dashboard.charitable-donations.index');
        })->name('master.charitable-donations.index');

        // donations

        Route::resource('/infaq', InfaqController::class);

        // donors
        Route::resource('/donors', DonorController::class);

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
        Route::put('/donations/donation-offline/{id}', [DonationController::class, 'updateOfflineDonation'])->name('transaction.donations.offline-donation.update');
        Route::delete('/donations/donation-offline/{id}', [DonationController::class, 'destroyOfflineDonation'])->name('transaction.donations.offline-donation.destroy');

        // donation online
        Route::get('/donations/online/{fundraisingProgramId}', [DonationController::class, 'showOnlineDonationForm'])->name('donations.online.form');
        Route::post('/donations/online/{fundraisingProgramId}', [DonationController::class, 'storeOnlineDonation'])->name('donations.online.store');

        // donor transfer confirmation
        Route::get('/donor-transfer-confirmations', [DonationController::class, 'listDonorTransferConfirmations'])->name('transaction.donor-transfer-confirmations.index');
        Route::put('/donor-transfer-confirmation/{id}', [DonationController::class, 'updateDonorTransferConfirmation'])->name('transaction.donor-transfer-confirmation.update');
        Route::put('/donor-transfer-confirmation/reject/{id}', [DonationController::class, 'updateDonorTransferRejection'])->name('transaction.donor-transfer-confirmation.rejection');

        Route::get('/infaq-donations', [DonationController::class, 'listInfaqDonations'])->name('transaction.infaq-donations.index');
        Route::post('/infaq-donations', [DonationController::class, 'storeInfaqDonation'])->name('transaction.infaq-donations.store');
        Route::put('/infaq-donations/{id}', [DonationController::class, 'updateInfaqDonation'])->name('transaction.infaq-donations.update');
        Route::delete('/infaq-donations/{id}', [DonationController::class, 'destroyInfaqDonation'])->name('transaction.infaq-donations.destroy');

        Route::prefix('expenses')->group(function () {
            Route::get('program-expenses', [ExpenseController::class, 'indexProgramExpenses'])->name('transaction.expenses.program-expenses.index');
            Route::post('program-expenses', [ExpenseController::class, 'storeProgramExpense'])->name('transaction.expenses.program-expenses.store');
        });
    });
});



