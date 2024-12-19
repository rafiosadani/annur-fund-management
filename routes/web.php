<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DonationController;
use App\Http\Controllers\DonorController;
use App\Http\Controllers\DonorTransactionController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\FundraisingProgramController;
use App\Http\Controllers\GoodDonationController;
use App\Http\Controllers\GoodInventoryController;
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
    return redirect()->route('login');
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

Route::get('/transactions/donations/online/{fundraisingProgramId}', [DonationController::class, 'showOnlineDonationForm'])->name('donations.online.form')->middleware('web');
Route::post('/transactions/donations/online/{fundraisingProgramId}', [DonationController::class, 'storeOnlineDonation'])->name('donations.online.store')->middleware('web');

Route::middleware(['web', 'auth'])->group(function () {
    // route dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // change password
    Route::post('/change-password', [AuthController::class, 'saveChangePassword'])->name('change-password');

    // profile and edit profile
        Route::get('/profile', [AuthController::class, 'profile'])->name('profile');
    Route::put('/profile/{id}/update/', [AuthController::class, 'updateProfile'])->name('profile.update')->middleware('prevent.get.for.put');

    // master data
    Route::prefix('master')->group(function () {
        Route::group(['middleware' => ['role_or_permission:administrator|master_barang.view|master_barang.create|master_barang.update|master_barang.delete']], function () {
            // goods
            Route::get('/goods/restore/one/{id}', [GoodInventoryController::class, 'restore'])->name('goods.restore');
            Route::get('/goods/restoreAll', [GoodInventoryController::class, 'restoreAll'])->name('goods.restore.all');
            Route::resource('/good-inventories', GoodInventoryController::class);
        });

        // donors
        Route::group(['middleware' => ['role_or_permission:administrator|master_donatur.view|master_donatur.create|master_donatur.update|master_donatur.delete']], function () {
            Route::resource('/donors', DonorController::class);
        });

        // infaq types
        Route::group(['middleware' => ['role_or_permission:administrator|master_infaq.view|master_infaq.create|master_infaq.update|master_infaq.delete']], function () {
            Route::resource('/infaq', InfaqController::class);
        });

        // fundraising programs
        Route::group(['middleware' => ['role_or_permission:administrator|master_program-penggalangan-dana.view|master_program-penggalangan-dana.create|master_program-penggalangan-dana.update|master_program-penggalangan-dana.delete']], function () {
            Route::get('/fundraising-programs/restore/one/{id}', [FundraisingProgramController::class, 'restore'])->name('fundraising-programs.restore');
            Route::get('/fundraising-programs/restoreAll', [FundraisingProgramController::class, 'restoreAll'])->name('fundraising-programs.restore.all');
            Route::resource('/fundraising-programs', FundraisingProgramController::class);
        });

        // roles
        Route::group(['middleware' => ['role_or_permission:administrator|master_roles.view|master_roles.create|master_roles.update|master_roles.delete']], function () {
            Route::get('/roles/restore/one/{id}', [RoleController::class, 'restore'])->name('roles.restore');
            Route::get('/roles/restoreAll', [RoleController::class, 'restoreAll'])->name('roles.restore.all');
            Route::resource('/roles', RoleController::class);
        });

        // users
        Route::group(['middleware' => ['role_or_permission:administrator|master_user.view|master_user.create|master_user.update|master_user.delete']], function () {
            Route::get('/users/restore/one/{id}', [UserController::class, 'restore'])->name('users.restore');
            Route::get('/users/restoreAll', [UserController::class, 'restoreAll'])->name('users.restore.all');
            Route::resource('/users', UserController::class);
        });
    });

    Route::prefix('transactions')->group(function () {
        // donation offline
        Route::group(['middleware' => ['role_or_permission:administrator|transaksi-pemasukan_donasi-offline.view|transaksi-pemasukan_donasi-offline.create|transaksi-pemasukan_donasi-offline.update|transaksi-pemasukan_donasi-offline.delete']], function () {
            Route::get('/donations/donation-offline', [DonationController::class, 'listOfflineDonations'])->name('transaction.donations.offline-donation.index');
            Route::post('/donations/donation-offline', [DonationController::class, 'storeOfflineDonation'])->name('transaction.donations.offline-donation.store');
            Route::put('/donations/donation-offline/{id}', [DonationController::class, 'updateOfflineDonation'])->name('transaction.donations.offline-donation.update');
            Route::delete('/donations/donation-offline/{id}', [DonationController::class, 'destroyOfflineDonation'])->name('transaction.donations.offline-donation.destroy');
        });

        // donation online
        // Route::get('/donations/online/{fundraisingProgramId}', [DonationController::class, 'showOnlineDonationForm'])->name('donations.online.form');
        // Route::post('/donations/online/{fundraisingProgramId}', [DonationController::class, 'storeOnlineDonation'])->name('donations.online.store');

        // infaq donations
        Route::group(['middleware' => ['role_or_permission:administrator|transaksi-pemasukan_infaq.view|transaksi-pemasukan_infaq.create|transaksi-pemasukan_infaq.update|transaksi-pemasukan_infaq.delete']], function () {
            Route::get('/infaq-donations', [DonationController::class, 'listInfaqDonations'])->name('transaction.infaq-donations.index');
            Route::post('/infaq-donations', [DonationController::class, 'storeInfaqDonation'])->name('transaction.infaq-donations.store');
            Route::put('/infaq-donations/{id}', [DonationController::class, 'updateInfaqDonation'])->name('transaction.infaq-donations.update');
            Route::delete('/infaq-donations/{id}', [DonationController::class, 'destroyInfaqDonation'])->name('transaction.infaq-donations.destroy');
        });

        // donor transfer confirmation
        Route::group(['middleware' => ['role_or_permission:administrator|transaksi-pemasukan_konfirmasi-transfer-donatur.view|transaksi-pemasukan_konfirmasi-transfer-donatur.create']], function () {
            Route::get('/donor-transfer-confirmations', [DonationController::class, 'listDonorTransferConfirmations'])->name('transaction.donor-transfer-confirmations.index');
            Route::put('/donor-transfer-confirmation/{id}', [DonationController::class, 'updateDonorTransferConfirmation'])->name('transaction.donor-transfer-confirmation.update');
            Route::put('/donor-transfer-confirmation/reject/{id}', [DonationController::class, 'updateDonorTransferRejection'])->name('transaction.donor-transfer-confirmation.rejection');
        });

        // goods donations
        Route::group(['middleware' => ['role_or_permission:administrator|transaksi-barang_donasi-barang.view|transaksi-barang_donasi-barang.create']], function () {
            Route::resource('/donations/good-donations', GoodDonationController::class);
        });

        Route::prefix('expenses')->group(function () {
            // general expenses
            Route::group(['middleware' => ['role_or_permission:administrator|transaksi-pengeluaran_pengeluaran-umum.view|transaksi-pengeluaran_pengeluaran-umum.create']], function () {
                Route::get('general-expenses', [ExpenseController::class, 'indexGeneralExpenses'])->name('transaction.expenses.general-expenses.index');
                Route::post('general-expenses', [ExpenseController::class, 'storeGeneralExpense'])->name('transaction.expenses.general-expenses.store');
                Route::put('general-expenses/{id}', [ExpenseController::class, 'updateGeneralExpense'])->name('transaction.expenses.general-expenses.update');
                Route::delete('general-expenses/{id}', [ExpenseController::class, 'destroyGeneralExpense'])->name('transaction.expenses.general-expenses.destroy');
            });

            // program expenses
            Route::group(['middleware' => ['role_or_permission:administrator|transaksi-pengeluaran_pengeluaran-program.view|transaksi-pengeluaran_pengeluaran-program.create']], function () {
                Route::get('program-expenses', [ExpenseController::class, 'indexProgramExpenses'])->name('transaction.expenses.program-expenses.index');
                Route::post('program-expenses', [ExpenseController::class, 'storeProgramExpense'])->name('transaction.expenses.program-expenses.store');
                Route::put('program-expenses/{id}', [ExpenseController::class, 'updateProgramExpense'])->name('transaction.expenses.program-expenses.update');
                Route::delete('program-expenses/{id}', [ExpenseController::class, 'destroyProgramExpense'])->name('transaction.expenses.program-expenses.destroy');
            });
        });
    });

    Route::prefix('donor')->group(function () {
        Route::get('/donations', [DonorTransactionController::class, 'listDonations'])->name('donor.donations.index');
    });
});



