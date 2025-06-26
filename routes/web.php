<?php

use App\Http\Controllers\HouseholdController;
use App\Http\Controllers\InvitationController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
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
    return view('auth/login');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/profile', [UserController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [UserController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [UserController::class, 'destroy'])->name('profile.destroy');

//    New route for completing profile
    Route::get('/complete-profile', [ProfileController::class, 'showForm'])->name('profile.complete');
    Route::post('/complete-profile', [ProfileController::class, 'store'])->name('profile.complete.store');
});

if (app()->isLocal()) {
    Route::group(['middleware' => ['web', 'auth']], function () {
    });
}
// household controllers
Route::middleware(['auth'])->group(function () {
    Route::get('/household', [HouseholdController::class, 'manage'])->name('household.manage');
    Route::post('/household', [HouseholdController::class, 'store'])->name('household.store');
    Route::put('/household/{household}', [HouseholdController::class, 'update'])->name('household.update');

});

Route::middleware(['auth'])->group(function () {
   Route::post('/invite', [InvitationController::class, 'store'])->name('invite.store');
   Route::get('/invite', [InvitationController::class, 'index'])->name('invite.index');
   Route::put('/invite/{invitation}', [InvitationController::class, 'update'])->name('invite.update');
});


require __DIR__.'/auth.php';
