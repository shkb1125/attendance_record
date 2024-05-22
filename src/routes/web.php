<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\RestController;


// Route::get('/', function () {
//     return view('stamp');
// });

// Route::middleware('auth')->group(function () {
    Route::get('/', [AttendanceController::class, 'index']);
    Route::get('/attendance', [AttendanceController::class, 'index']);
    Route::get('/attendance/{date?}', [AttendanceController::class, 'date']);
    Route::post('/attendance/start', [AttendanceController::class, 'start']);
    Route::post('/attendance/end', [AttendanceController::class, 'stop']);
    Route::post('/rest/start', [RestController::class, 'start']);
    Route::post('/rest/end', [RestController::class, 'stop']);
// });




// Route::get('/attendance', function () {
//     return view('attendance');
// });
Route::get('/register', function () {
    return view('auth.register');
});
Route::get('/login', function () {
    return view('auth.login');
});

// Route::post('/logout', function () {
//     Auth::logout();
//     return redirect('/');
// })->name('logout');