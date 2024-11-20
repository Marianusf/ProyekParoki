<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PeminjamController;

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

Route::get('/peminjam', function () {
    return view('layoutPeminjam');
});

Route::get('/ruangan', function () {
    return view('ruangan');
});

Route::get('/navbar', function () {
    return view('navbar');
});

Route::get('/dashboard', [PeminjamController::class, 'Dashboard'])->name('dashboard.DashbaordRuangan');


Route::get('/pinjam', [PeminjamController::class, 'index'])->name('pinjam.ViewRuangan');
Route::get('/pinjam/ruangan', [PeminjamController::class, 'DaftarRuangan'])->name('pinjam.FormRuangan');
Route::get('/pinjam/ruangan/informasiRuangan', [PeminjamController::class, 'InformasiRuangan'])->name('pinjam.InformasiRuangan');

Route::get('/edit', [PeminjamController::class, 'EditAdmin'])->name('sdit.AdminEdit');



//Menyimpan data ruangan yang akan disimpan ke dalam database
Route::post('/masuk/save', [PeminjamController::class, 'saveDataRuangan'])->name('masuk.SaveDataRuangan');

Route::post('/peminjaman', [PeminjamController::class, 'store'])->name('peminjaman.store');
Route::post('/pinjam/ruangan', [PeminjamController::class, 'storeRuangan'])->name('pinjam.ruangan');
