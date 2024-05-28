<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\RestController;
use App\Http\Controllers\RegisteredUserController;
use App\Http\Controllers\LoginController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;

// Route::get('/register', function () {
//     return view('auth.register');
// });

// Route::get('/login', function () {
//     return view('auth.login');
// });

Route::middleware('auth')->group(function () {
    Route::get('/', [AttendanceController::class, 'index']);
    Route::get('/attendance', [AttendanceController::class, 'show']);
    Route::get('/attendance/{date?}', [AttendanceController::class, 'show'])->name('attendance.show');
    Route::post('/attendance/start', [AttendanceController::class, 'start']);
    Route::post('/attendance/end', [AttendanceController::class, 'stop']);
    Route::post('/rest/start', [RestController::class, 'start']);
    Route::post('/rest/end', [RestController::class, 'stop']);
});

Route::get('/register', [RegisteredUserController::class, 'create']);
Route::post('/register', [RegisteredUserController::class, 'store']);

Route::get('/login', [LoginController::class, 'index'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::get('/email/verify', function () {
    return view('auth.verify-email');
})->middleware('auth')->name('verification.notice');

Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();
    return redirect('/');
})->middleware(['auth', 'signed'])->name('verification.verify');

Route::post('/email/verification-notification', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();
    return back()->with('message', 'Verification link sent!');
})->middleware(['auth', 'throttle:6,1'])->name('verification.send');

