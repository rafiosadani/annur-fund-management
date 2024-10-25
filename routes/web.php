<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DonorController;
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

        Route::resource('/master/donors', DonorController::class);

        // roles
        Route::get('/roles/restore/one/{id}', [RoleController::class, 'restore'])->name('roles.restore');
        Route::get('/roles/restoreAll', [RoleController::class, 'restoreAll'])->name('roles.restore.all');
        Route::resource('/roles', RoleController::class);

        // users
        Route::get('/users/restore/one/{id}', [UserController::class, 'restore'])->name('users.restore');
        Route::get('/users/restoreAll', [UserController::class, 'restoreAll'])->name('users.restore.all');
        Route::resource('/users', UserController::class);
    });

    Route::post('/roles/restoreAll', [RoleController::class, 'restoreAll'])->name('roles.restore.all');
});



<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\InfaqController;
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

//route infaq
// Route::get('/master/charitable-donations', [InfaqController::class, 'index'])->name('master.charitable-donations.index');
// Route::post('/infaqstore', [InfaqController::class, 'store'])->name('infaq.store');
// Route::put('/infaqupdate', [InfaqController::class, 'update'])->name('infaq.update');

// route authentication - can't be accessed yet
Route::get('/login', function () {
    return view('auth.login');
})->name('web.login')->middleware('guest');

Route::get('/register', function () {
    return view('auth.register');
})->name('web.register')->middleware('guest');

Route::post('/login', [AuthController::class, 'authenticate'])->name('authenticate')->middleware('guest');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

Route::post('/register', [AuthController::class, 'register'])->name('register')->middleware('guest');

// route dashboard
Route::get('/dashboard', function () {
    return view('dashboard.index');
})->name('dashboard');

// route master data
// route charitable donations
// Route::get('/master/charitable-donations', function () {
//     return view('dashboard.charitable-donations.index');
// })->name('master.charitable-donations.index');

//Route::get('/master/users', function () {
//    return view('dashboard.users.index');
//})->name('master.users.index');

Route::get('/master/users/restore/one/{id}', [UserController::class, 'restore'])->name('users.restore');
Route::get('/master/users/restoreAll', [UserController::class, 'restoreAll'])->name('users.restore.all');
Route::resource('/master/users', UserController::class);


Route::resource('/master/roles', RoleController::class);

Route::resource('/master/infaq', InfaqController::class);

