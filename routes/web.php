<?php

use App\Http\Controllers\GroceryDashboardController;
use App\Http\Controllers\GroceryListItemController;
use App\Http\Controllers\HouseholdController;
use App\Http\Controllers\InvitationController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;

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
Route::get('/debug', function () {
    Log::error('Testing Laravel logging on Heroku.');
    return 'Check logs!';
});

Route::get('/debug-log', function () {
    Log::error('This is a test log entry.');
    abort(500, 'Testing 500 error logging.');
});

Route::get('/', function () {
    return view('auth/login');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/profile', [UserController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [UserController::class, 'update'])->name('profile.update');
    Route::put('/profile', [UserController::class, 'updateProfilePicture'])->name('profile.updatePicture');
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

Route::middleware(['auth'])->group(function () {
    Route::get('/chores', [\App\Http\Controllers\ChoreController::class, 'index'])->name('chores.index');
    Route::post('/chores', [\App\Http\Controllers\ChoreController::class, 'store'])->name('chores.store');
    Route::get('/chores/create', [\App\Http\Controllers\ChoreController::class, 'create'])->name('chores.create');

    Route::view('/chores/create-batch', 'chores.create')->name('chores.create-batch');
    Route::view('/chores/manage', 'chores.manage')->name('chores.manage');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/groceries',[GroceryDashboardController::class, 'index'])->name('groceries.index');
    Route::get('/groceries/create/{groceryList}',[\App\Http\Controllers\GroceryListItemController::class, 'create'])->name('listItems.create');
    Route::get('/groceries/edit/{groceryList}', [GroceryListItemController::class, 'edit'])->name('listItems.edit');
});


require __DIR__.'/auth.php';




