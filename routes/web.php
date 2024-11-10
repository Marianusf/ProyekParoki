<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

Route::get('/', function () {
    return view('layout.TemplateAdmin');
});


use Illuminate\Support\Facades\Mail;


// Route untuk lupa password
Route::get('password/reset', [AuthController::class, 'showLinkRequestForm'])->name('password.request');
Route::post('password/email', [AuthController::class, 'sendResetLinkEmail'])->name('password.email');

// Route untuk reset password
Route::get('password/reset/{token}', [AuthController::class, 'showResetForm'])->name('password.reset');
Route::post('password/reset', [AuthController::class, 'reset'])->name('password.update');



Route::get('/register', function () {
    return view('auth.register');
})->name('register.form');

Route::post('/register', [AuthController::class, 'register'])->name('register');

Route::get('/login', function () {
    return view('auth.login');
})->name('login.form');

Route::post('/login', [AuthController::class, 'login'])->name('login');


// Rute POST untuk memproses persetujuan akun peminjam
Route::post('/approve/{id}', [AuthController::class, 'approve'])->name('approve.peminjam');
Route::get('/requests', [AuthController::class, 'showApprovalRequests'])->name('requests');
Route::post('/peminjam/tolak/{id}', [AuthController::class, 'rejectAccount'])->name('reject.peminjam');

Route::get('/ruangan', function () {
    return view('ruangan');
});

Route::get('/layoutPeminjam', function () {
    return view('layout.layoutpeminjam');
});

Route::get('/layoutPeminjam', function () {
    return view('layout.layoutpeminjam');
});

Route::get('/pengembalian', function () {
    return view('pengembalian');
});