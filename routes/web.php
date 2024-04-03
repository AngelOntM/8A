<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ChirpController;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use App\Http\Controllers\ContactController;
use Illuminate\Support\Facades\URL;
use App\Http\Controllers\UserController;

use App\Http\Controllers\TwoFactorController;
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
})->middleware(['guest'])->name('welcome');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified', 'threefactor', 'vpn.access', 'twofactor'])->name('dashboard');


Route::middleware(['auth', 'signed', 'threefactor', 'vpn.access', 'verified', 'twofactor'])->group(function () {
    Route::get('/chirps', [ChirpController::class, 'index'])->name('chirps.index');
    Route::post('/chirps', [ChirpController::class, 'store'])->middleware('adminorcoor')->name('chirps.store');
    Route::get('/chirps/{chirp}/edit', [ChirpController::class, 'edit'])->middleware('adminorcoor')->name('chirps.edit');
    Route::put('/chirps/{chirp}', [ChirpController::class, 'update'])->middleware('adminorcoor')->name('chirps.update');
    Route::delete('/chirps/{chirp}', [ChirpController::class, 'destroy'])->middleware('adminorcoor')->name('chirps.destroy');
});


Route::middleware(['auth', 'signed', 'threefactor', 'vpn.access', 'verified', 'twofactor'])->group(function () {
    Route::get('/users', [UserController::class, 'index'])->middleware('admin')->name('users.index');
    Route::get('/users/{user}/edit', [UserController::class, 'edit'])->middleware('admin')->name('users.edit');
    Route::put('/users/{user}', [UserController::class, 'update'])->middleware('admin')->name('users.update');
    Route::get('/users/{user}/editpassword', [UserController::class, 'editpassword'])->middleware('admin')->name('users.editpassword');
    Route::put('/userpassword/{user}', [UserController::class, 'updatepassword'])->middleware('admin')->name('users.updatepassword');
    Route::delete('/users/{user}', [UserController::class, 'destroy'])->middleware('admin')->name('users.destroy');
});


Route::middleware(['auth', 'signed', 'threefactor', 'vpn.access', 'verified', 'twofactor'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});



Route::get('/email/verify', function () {
    return view('auth.verify-email');
})->middleware('auth')->name('verification.notice');
 
Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();
    return redirect('/home');
})->middleware(['auth', 'signed'])->name('verification.verify');
 
Route::post('/email/verification-notification', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();
 
    return back()->with('message', 'Verification link sent!');
})->middleware(['auth', 'throttle:6,1'])->name('verification.send');



Route::middleware(['auth', 'threefactor', 'vpn.access', 'verified', 'twofactor'])->group(function () {
    Route::get('/verify/resend', [TwoFactorController::class, 'resend'])->name('verify.resend');
    Route::get('/verify', [TwoFactorController::class, 'index'])->name('verify.index');
    Route::post('/verify', [TwoFactorController::class, 'store'])->name('verify.store');
});

require __DIR__.'/auth.php';
