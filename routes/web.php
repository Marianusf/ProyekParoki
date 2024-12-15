<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\AssetController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\PeminjamanController;
use App\Http\Controllers\AlatMisaController;
use App\Http\Controllers\PeminjamanAlatMisaController;
use App\Http\Controllers\PeminjamanRuanganController;
use App\Http\Controllers\PeminjamController;
use App\Http\Controllers\PengembalianController;
use App\Http\Controllers\RuanganController;
use App\Models\Alat_Misa;

//peminjamanRuangan
// Route untuk Sekretariat - Mengelola Permintaan Peminjaman
Route::middleware(['auth:admin'])->group(function () {
    Route::get('/admin-sekretariat/permintaan-peminjaman', [PeminjamanRuanganController::class, 'index'])->name('peminjaman.index');
    Route::post('/peminjaman/{id}/approve', [PeminjamanRuanganController::class, 'approvePeminjaman'])->name('peminjaman.approve');
    Route::post('/peminjaman/reject/{id}', [PeminjamanRuanganController::class, 'rejectPeminjaman'])->name('peminjaman.reject');
});
Route::get('/kalender', [PeminjamanRuanganController::class, 'showCalendar'])->name('kalender');


// Route untuk Peminjam - Ajukan Peminjaman
Route::middleware(['auth:peminjam'])->group(function () {
    Route::get('/peminjam/pinjam-ruangan', [PeminjamanRuanganController::class, 'create'])->name('peminjaman.create');
    Route::post('/peminjam/pinjam-ruangan', [PeminjamanRuanganController::class, 'store'])->name('peminjaman.store');
});
// KELOLA RUANGAN
Route::get('ruangan/create', [RuanganController::class, 'create'])->name('ruangan.create');
Route::post('ruanganStore', [RuanganController::class, 'store'])->name('ruangan.store');
Route::get('ruangan/{ruangan}/edit', [RuanganController::class, 'edit'])->name('ruangan.edit');
Route::put('ruangan/{ruangan}', [RuanganController::class, 'update'])->name('ruangan.update');

Route::get('lihatSemuaRuangan', [RuanganController::class, 'lihatSemuaRuangan'])->name('lihatSemuaRuangan');
Route::get('cekKetersediaanRuangan', [RuanganController::class, 'cekKetersediaanRuangan'])->name('cekKetersediaanRuangan');
// Route untuk menghapus ruangan
Route::delete('/ruangan/{ruangan}', [RuanganController::class, 'destroy'])->name('ruangan.destroy');



//untuk kelola peminjam
Route::get('lihatProfile', [PeminjamController::class, 'lihatProfile'])->name('lihatProfile');
Route::put('lihatProfile', [PeminjamController::class, 'lihatProfile'])->name('lihatProfile');

Route::middleware('auth:peminjam')->get('lihatProfile', [PeminjamController::class, 'lihatProfile'])->name('lihatProfile');

// Menampilkan form untuk mengedit profil
Route::middleware('auth:peminjam')->get('/profile/edit', [PeminjamController::class, 'editProfile'])->name('profile.edit');

// Menyimpan perubahan profil
Route::middleware('auth:peminjam')->put('/profile/update', [PeminjamController::class, 'updateProfile'])->name('profile.update');

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
        return view('layout.AdminSekretariatView.HomeAdminSekretariat');
    })->name('sekretariat.dashboard');
    Route::get('/paramenta/dashboard', function () {
        return view('layout.AdminParamentaView.HomeAdminParamenta');
    })->name('paramenta.dashboard');

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
Route::put('/asset/{id}', [AssetController::class, 'update'])->name('asset.update');

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


// Route::middleware(['auth:peminjam'])->group(function () {
Route::post('/keranjang/tambah', [PeminjamanController::class, 'tambahKeKeranjang'])->name('keranjang.tambah');
Route::get('/keranjang', [PeminjamanController::class, 'lihatKeranjang'])->name('lihatKeranjang');
Route::post('/checkout', [PeminjamanController::class, 'prosesCheckout'])->name('checkout');
Route::get('/riwayat-peminjaman', [PeminjamanController::class, 'lihatRiwayatPeminjaman'])->name('riwayatPeminjaman');
// Menampilkan halaman peminjaman asset
// Route untuk menampilkan halaman form peminjaman
Route::get('/pinjam-asset', [PeminjamanController::class, 'tampilPinjamAsset'])->name('pinjam.asset');
Route::get('/peminjam/ketersediaan-asset', [AssetController::class, 'peminjamLihatKetersediaanAsset'])->name('peminjam.ketersediaanAsset');
// });

// Route::middleware(['auth', 'can:isAdmin'])->group(function () {
Route::post('/peminjaman/{id}/setujui', [PeminjamanController::class, 'setujuiPeminjaman'])->name('peminjaman.setujui');
Route::post('/peminjaman/{id}/tolak', [PeminjamanController::class, 'tolakPeminjaman'])->name('peminjaman.tolak');
// Batch action untuk setujui atau tolak peminjaman sekaligus banyak
Route::post('/peminjaman/batch-action', [PeminjamanController::class, 'batchAction'])->name('peminjaman.batch_action');

// });
Route::get('/admin/peminjamanasset', [AdminController::class, 'lihatPermintaanPeminjaman'])->name('lihatPermintaanPeminjaman');
Route::get('/ketersediaan-asset', [AssetController::class, 'cekKetersediaanAsset'])->name('ketersediaanAsset');


//proses pengembalian
Route::get('/pengembalian/form', [PengembalianController::class, 'showPengembalianForm'])->name('pengembalian.form');

// Mengirimkan pengajuan pengembalian
Route::post('/pengembalian/store', [PengembalianController::class, 'storePengembalian'])->name('pengembalian.store');
Route::get('/admin/pengembalian', [AdminController::class, 'adminLihatPermintaanPengembalian'])->name('admin.PermintaanPengembalianAsset');

// Menyetujui pengembalian
Route::patch('/admin/pengembalian/{id}/approve', [PengembalianController::class, 'approvePengembalian'])->name('pengembalian.approve');

// Menolak pengembalian dengan alasan
Route::patch('/admin/pengembalian/{id}/reject', [PengembalianController::class, 'rejectPengembalian'])->name('pengembalian.reject');

Route::get('/pengembalian', [PengembalianController::class, 'index'])->name('pengembalian.index');
Route::post('/pengembalian/setujui/{id}', [PengembalianController::class, 'approve'])->name('pengembalian.setujui');
Route::post('/pengembalian/tolak/{id}', [PengembalianController::class, 'reject'])->name('pengembalian.tolak');
Route::post('/pengembalian/batch_action', [PengembalianController::class, 'batchAction'])->name('pengembalian.batch_action');




Route::prefix('alat-misa')->group(function () {
    Route::get('/', [AlatMisaController::class, 'index'])->name('alat_misa.index');
    Route::get('/create', [AlatMisaController::class, 'create'])->name('alat_misa.create');
    Route::post('/', [AlatMisaController::class, 'store'])->name('alat_misa.store');
    Route::get('/{id}/edit', [AlatMisaController::class, 'edit'])->name('alat_misa.edit');
    Route::put('/{id}', [AlatMisaController::class, 'update'])->name('alat_misa.update');
    Route::delete('/{id}', [AlatMisaController::class, 'destroy'])->name('alat_misa.destroy');
});



//untuk Paramenta alat misa
// Route::middleware(['auth:peminjam'])->group(function () {
Route::post('/keranjang/tambah', [PeminjamanAlatMisaController::class, 'tambahKeKeranjangAlatMisa'])->name('keranjangAlatMisa.tambah');
Route::get('/keranjang', [PeminjamanAlatMisaController::class, 'lihatKeranjangAlatMisa'])->name('lihatKeranjangAlatMisa');
Route::post('/checkout', [PeminjamanAlatMisaController::class, 'prosesCheckoutAlatMisa'])->name('checkout');
Route::get('/riwayat-peminjaman', [PeminjamanAlatMisaController::class, 'lihatRiwayatPeminjaman'])->name('riwayatPeminjamanAlatMisa');
// Menampilkan halaman peminjaman asset
// Route untuk menampilkan halaman form peminjaman
Route::get('/pinjam-asset', [PeminjamanAlatMisaController::class, 'tampilPinjamAlatMisa'])->name('pinjam.alatmisa');
Route::get('/peminjam/ketersediaan-asset', [AlatMisaController::class, 'peminjamLihatKetersediaanAsset'])->name('peminjam.ketersediaanAsset');
Route::get('/admin/peminjamanalatmisa', [AdminController::class, 'lihatPermintaanPeminjamanAlatMisa'])->name('lihatPermintaanPeminjamanAlatMisa');
// });
Route::post('/peminjamanalatmisa/{id}/setujui', [PeminjamanALatMisaController::class, 'setujuiPeminjamanAlatMisa'])->name('alatmisa.setujui');
Route::post('/peminjamanalatmisa/{id}/tolak', [PeminjamanALatMisaController::class, 'tolakPeminjaman'])->name('alatmisa.tolak');
// Batch action untuk setujui atau tolak peminjaman sekaligus banyak
Route::post('/peminjamanalatmisa/batch-action', [PeminjamanALatMisaController::class, 'batchAction'])->name('alatmisa.batch_action');
Route::get('/ketersediaan-alatmisa', [AlatMisaController::class, 'cekKetersediaanAlatMisa'])->name('lihatKetersediaanAlatMisa');
