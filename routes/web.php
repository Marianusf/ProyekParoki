<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\AssetController;
use App\Http\Controllers\AdminController;

Route::get('/profil', function () {
    return view('layout.PeminjamView.Profile');
});


// Rute untuk lupa password
Route::get('password/reset', [AuthController::class, 'showLinkRequestForm'])->name('password.request');
Route::post('password/email', [AuthController::class, 'sendResetLinkEmail'])->name('password.email');

// Rute untuk reset password
Route::get('password/reset/{token}', [AuthController::class, 'showResetForm'])->name('password.reset');
Route::post('password/reset', [AuthController::class, 'reset'])->name('password.update');

// Rute untuk registrasi
Route::get('/register', function () {
    return view('auth.register');
})->name('register.form');
Route::post('/register', [AuthController::class, 'register'])->name('register');

// Rute untuk login
Route::get('/login', function () {
    return view('auth.login');
})->name('login.form');
Route::post('/login', [AuthController::class, 'login'])->name('login');

// Rute untuk logout
Route::post('/logout', function () {
    Auth::logout();
    return redirect('/login');
})->name('logout');

// Rute dengan middleware untuk admin dan sekretariat
Route::middleware('auth:admin')->group(function () {
    Route::get('/admin/dashboard', function () {
        return view('layout.AdminView.HomeAdmin');
    })->name('admin.dashboard');

    Route::get('/sekretariat/dashboard', function () {
        return view('sekretariat.dashboard');
    })->name('sekretariat.dashboard');

    // Rute untuk memproses persetujuan akun peminjam hanya untuk admin
    Route::post('/approve/{id}', [AuthController::class, 'approve'])->name('approve.peminjam');
});

// Rute dengan middleware untuk peminjam
Route::middleware('auth:peminjam')->group(function () {
    Route::get('/peminjam/dashboard', function () {
        return view('layout.PeminjamView.HomePeminjam');
    })->name('peminjam.dashboard');
});

// Rute untuk requests (memerlukan autentikasi admin)
// Route::middleware('auth:admin')->group(function () {
Route::get('/requests', [AuthController::class, 'showApprovalRequests'])->name('requests');
Route::post('/peminjam/tolak/{id}', [AuthController::class, 'rejectAccount'])->name('reject.peminjam');
// Rute POST untuk memproses persetujuan akun peminjam
Route::post('/approve/{id}', [AuthController::class, 'approve'])->name('approve.peminjam');
Route::get('/requests', [AuthController::class, 'showApprovalRequests'])->name('requests');
Route::post('/peminjam/tolak/{id}', [AuthController::class, 'rejectAccount'])->name('reject.peminjam');

// Route untuk menampilkan form tambah asset
Route::get('/admin/asset/tambah', [AssetController::class, 'create'])->name('asset.create');

// Route untuk menampilkan daftar asset
Route::get('/admin/asset', [AssetController::class, 'index'])->name('asset.index');

// Route untuk menyimpan asset yang baru ditambahkan
Route::post('/admin/asset', [AssetController::class, 'store'])->name('asset.store');

Route::get('/peminjamaktif', [AdminController::class, 'listPeminjamAktif'])->name('lihat.peminjam.aktif');
// Route::middleware(['auth'])->group(function () {
Route::get('/admin/asset/edit/{id}', [AssetController::class, 'edit'])->name('asset.edit');
Route::delete('/admin/asset/{id}', [AssetController::class, 'destroy'])->name('asset.delete');
// });
// });
Route::get('/ruangan', function () {
    return view('ruangan');
});

Route::get('/TemplatePeminjam', function () {
    return view('layout.TemplatePeminjam');
});

Route::get('/pengembalian', function () {
    return view('pengembalian');
});
