<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\AssetController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\PeminjamanController;
use App\Http\Controllers\AlatMisaController;
use App\Http\Controllers\PeminjamanAlatMisaController;
use App\Http\Controllers\PengembalianAlatMisaController;
use App\Http\Controllers\PeminjamanRuanganController;
use App\Http\Controllers\PeminjamController;
use App\Http\Controllers\PengembalianController;
use App\Http\Controllers\RuanganController;
use App\Models\Alat_Misa;
use App\Models\Peminjaman;
use App\Models\PeminjamanRuangan;
use App\Models\Peminjam;
use App\Models\PeminjamanAlatMisa;
use App\Models\Pengembalian;
use App\Models\PengembalianAlatMisa;
use Carbon\Carbon;

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
Route::get('/riwayat-peminjaman-ruangan', [PeminjamanRuanganController::class, 'lihatRiwayatPeminjamanRuangan'])->name('riwayatPeminjamanRuangan');
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

Route::middleware('auth:peminjam')->group(function () {
    Route::get('/peminjam/dashboard', function () {
        $user = Auth::guard('peminjam')->user(); // Ambil data pengguna yang sedang login

        // 1. Perbarui status peminjaman ruangan jika waktu sudah habis
        PeminjamanRuangan::where('status_peminjaman', 'disetujui')
            ->where('peminjam_id', $user->id)
            ->whereDate('tanggal_selesai', '<', now()) // Jika tanggal selesai sudah lewat
            ->update(['status_peminjaman' => 'selesai']);

        // 2. Hitung peminjaman aktif
        $totalPeminjamanAktif = PeminjamanRuangan::where('status_peminjaman', 'disetujui')
            ->where('peminjam_id', $user->id)
            ->count()
            + PeminjamanAlatMisa::where('status_peminjaman', 'disetujui')
            ->where('id_peminjam', $user->id)
            ->count()
            + Peminjaman::where('status_peminjaman', 'disetujui')
            ->where('id_peminjam', $user->id)
            ->whereDoesntHave('pengembalian', function ($query) {
                $query->where('status', 'approved');
            }) // Filter yang belum ada pengembalian approved
            ->count();

        // 3. Hitung peminjaman selesai
        $totalPeminjamanSelesai = PeminjamanRuangan::where('status_peminjaman', 'selesai')
            ->where('peminjam_id', $user->id)
            ->count()
            + PeminjamanAlatMisa::where('status_peminjaman', 'selesai')
            ->where('id_peminjam', $user->id)
            ->count()
            + Peminjaman::whereHas('pengembalian', function ($query) {
                $query->where('status', 'approved');
            })
            ->where('id_peminjam', $user->id)
            ->count();

        // 4. Hitung persentase pemanfaatan
        $jumlahRuangan = PeminjamanRuangan::where('peminjam_id', $user->id)->count();
        $jumlahAlat = PeminjamanAlatMisa::where('id_peminjam', $user->id)->count();
        $jumlahAsset = Peminjaman::where('id_peminjam', $user->id)->count();

        $totalSemuaPeminjaman = $jumlahRuangan + $jumlahAlat + $jumlahAsset;

        $persenRuangan = $totalSemuaPeminjaman ? ($jumlahRuangan / $totalSemuaPeminjaman) * 100 : 0;
        $persenAlat = $totalSemuaPeminjaman ? ($jumlahAlat / $totalSemuaPeminjaman) * 100 : 0;
        $persenAsset = $totalSemuaPeminjaman ? ($jumlahAsset / $totalSemuaPeminjaman) * 100 : 0;

        // 5. Pengingat peminjaman ruangan yang akan habis dalam 3 hari
        $pengingatPeminjaman = PeminjamanRuangan::with('ruangan')
            ->where('status_peminjaman', 'disetujui')
            ->where('peminjam_id', $user->id)
            ->whereDate('tanggal_selesai', '>=', now()) // Masih valid
            ->whereDate('tanggal_selesai', '<=', now()->addDays(3)) // Akan selesai dalam 3 hari
            ->get()
            ->map(function ($item) {
                $tanggalPengembalian = Carbon::parse($item->tanggal_selesai);

                return [
                    'nama' => $item->ruangan->nama ?? 'Nama Ruangan Tidak Ditemukan',
                    'tanggal_selesai' => $tanggalPengembalian,
                    'sisa_waktu' => now()->diffForHumans($tanggalPengembalian, ['parts' => 2, 'syntax' => Carbon::DIFF_ABSOLUTE]),
                ];
            });

        // 6. Kirim data ke view
        return view('layout.PeminjamView.HomePeminjam', compact(
            'totalPeminjamanAktif',
            'totalPeminjamanSelesai',
            'persenRuangan',
            'persenAlat',
            'persenAsset',
            'pengingatPeminjaman'
        ));
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
Route::get('/peminjamaktif/byparamenta', [AdminController::class, 'listPeminjamAktifbyparamenta'])->name('lihat.peminjam.aktif.byparamenta');
Route::get('/peminjamaktif/bysekretariat', [AdminController::class, 'listPeminjamAktifbysekretariat'])->name('lihat.peminjam.aktif.bysekretariat');
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
Route::get('/peminjam/ketersediaan-asset', [PeminjamController::class, 'peminjamLihatKetersediaanAsset'])->name('peminjam.ketersediaanAsset');
Route::get('/peminjam/ketersediaan-alatMisa', [PeminjamController::class, 'peminjamLihatKetersediaanAlatMisa'])->name('peminjam.ketersediaanAlatMisa');
Route::get('/peminjam/ketersediaan-ruangan', [PeminjamController::class, 'peminjamLihatKetersediaanRuangan'])->name('peminjam.ketersediaanRuangan');

// });

// Route::middleware(['auth', 'can:isAdmin'])->group(function () {
Route::post('/peminjaman/{id}/setujui', [PeminjamanController::class, 'setujuiPeminjaman'])->name('peminjaman.setujui');
Route::post('/peminjaman/{id}/tolak', [PeminjamanController::class, 'tolakPeminjaman'])->name('peminjaman.tolak');
// Batch action untuk setujui atau tolak peminjaman sekaligus banyak
Route::post('/peminjaman/batch-action', [PeminjamanController::class, 'batchAction'])->name('peminjaman.batch_action');

// });
Route::get('/admin/peminjamanasset', [AdminController::class, 'lihatPermintaanPeminjaman'])->name('lihatPermintaanPeminjaman');
Route::get('/ketersediaan-asset', [AssetController::class, 'cekKetersediaanAsset'])->name('ketersediaanAsset');
Route::get('/admin-lihatriwayat-peminjaman-asset', [AdminController::class, 'LihatRiwayatPeminjamanAsset'])->name('lihat.riwayat.peminjaman-asset');
Route::get('/admin-lihatriwayat-peminjaman-alatmisa', [AdminController::class, 'LihatRiwayatPeminjamanAlatMisa'])->name('lihat.riwayat.peminjaman-alatmisa');
Route::get('/admin-lihatriwayat-peminjaman-ruangan', [AdminController::class, 'LihatRiwayatPeminjamanRuangan'])->name('lihat.riwayat.peminjaman-ruangan');

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
Route::post('/keranjang/tambah/alatmisa', [PeminjamanAlatMisaController::class, 'tambahKeKeranjangAlatMisa'])->name('keranjangAlatMisa.tambah');
Route::get('/keranjangAlatMisa', [PeminjamanAlatMisaController::class, 'lihatKeranjangAlatMisa'])->name('lihatKeranjangAlatMisa');
Route::post('/checkoutALatMisa', [PeminjamanAlatMisaController::class, 'prosesCheckoutAlatMisa'])->name('checkoutAlatMisa');
Route::get('/riwayat-peminjaman-alatmisa', [PeminjamanAlatMisaController::class, 'lihatRiwayatPeminjamanAlatMisa'])->name('riwayatPeminjamanAlatMisa');
// Menampilkan halaman peminjaman asset
// Route untuk menampilkan halaman form peminjaman
Route::get('/pinjam-alat-misa', [PeminjamanAlatMisaController::class, 'tampilPinjamAlatMisa'])->name('pinjam.alatmisa');
Route::get('/admin/peminjamanalatmisa', [AdminController::class, 'lihatPermintaanPeminjamanAlatMisa'])->name('lihatPermintaanPeminjamanAlatMisa');
// });
Route::post('/peminjamanalatmisa/{id}/setujui', [PeminjamanALatMisaController::class, 'setujuiPeminjamanAlatMisa'])->name('alatmisa.setujui');
Route::post('/peminjamanalatmisa/{id}/tolak', [PeminjamanALatMisaController::class, 'tolakPeminjaman'])->name('alatmisa.tolak');
// Batch action untuk setujui atau tolak peminjaman sekaligus banyak
Route::post('/peminjamanalatmisa/batch-action', [PeminjamanALatMisaController::class, 'batchAction'])->name('alatmisa.batch_action');
Route::get('/admin-ketersediaan-alatmisa', [AlatMisaController::class, 'cekKetersediaanAlatMisa'])->name('lihatKetersediaanAlatMisa');



///proses pengembalian alat misa

//proses pengembalian
Route::get('/pengembalianAlatMisa/form', [PengembalianAlatMisaController::class, 'showPengembalianAlatMisaForm'])->name('pengembalianAlatMisa.form');
Route::post('/pengembalian-alat-misa', [PengembalianAlatMisaController::class, 'storePengembalianAlatMisa'])->name('pengembalianAlatMisa.store');
Route::post('/pengembalian-alat-misa/{id}/reject', [PengembalianAlatMisaController::class, 'reject'])->name('pengembalianAlatMisa.reject');
Route::post('/pengembalian-alat-misa/batch-action', [PengembalianAlatMisaController::class, 'batchAction'])->name('pengembalianAlatMisa.batchAction');
Route::post('/pengembalian-alat-misa/batch', [PengembalianAlatMisaController::class, 'batchAction'])->name('pengembalianAlatMisa.batch_action');
Route::post('/pengembalian-alat-misa/approve/{id}', [PengembalianAlatMisaController::class, 'approve'])->name('pengembalianAlatMisa.approve');
Route::post('/pengembalian-alat-misa/reject/{id}', [PengembalianAlatMisaController::class, 'reject'])->name('pengembalianAlatMisa.reject');
Route::get('/admin/pengembalian-AlatMisa', [AdminController::class, 'adminLihatPermintaanPengembalianAlatMisa'])->name('admin.PermintaanPengembalianALatMisa');



//untuk homepage
Route::middleware('auth:admin')->group(function () {
    // Admin Dashboard
    Route::get('/admin/dashboard', function () {
        // Statistik Dinamis
        $persetujuanAkun = Peminjam::where('is_approved', 'false')->count();
        $peminjamanAktif = Peminjaman::where('status_peminjaman', 'disetujui')->count();
        $permintaanPeminjaman = Peminjaman::where('status_peminjaman', 'pending')->count();

        // Data Grafik Peminjaman Bulanan
        $peminjamanPerBulan = Peminjaman::selectRaw('MONTH(created_at) as bulan, COUNT(*) as total')
            ->groupBy('bulan')
            ->orderBy('bulan')
            ->pluck('total', 'bulan');

        // Kirim data ke view
        return view('layout.AdminView.HomeAdmin', compact('persetujuanAkun', 'peminjamanAktif', 'permintaanPeminjaman', 'peminjamanPerBulan'));
    })->name('admin.dashboard');

    // Sekretariat Dashboard
    Route::get('/sekretariat/dashboard', function () {
        // Ambil data jumlah peminjaman ruangan per bulan
        $dataBulanan = PeminjamanRuangan::selectRaw('MONTH(created_at) as bulan, COUNT(*) as total')
            ->groupBy('bulan')
            ->pluck('total', 'bulan');

        // Inisialisasi semua bulan (1–12) dengan nilai 0
        $dataLengkap = array_fill(1, 12, 0);

        // Isi data sesuai bulan yang ada
        foreach ($dataBulanan as $bulan => $total) {
            $dataLengkap[$bulan] = $total;
        }

        // Kirim data ke view
        return view('layout.AdminSekretariatView.HomeAdminSekretariat', [
            'persetujuanRuangan' => PeminjamanRuangan::where('status_peminjaman', 'pending')->count(),
            'peminjamanAktifRuangan' => PeminjamanRuangan::where('status_peminjaman', 'disetujui')->count(),
            'totalPermintaanRuangan' => PeminjamanRuangan::count(),
            'peminjamanRuanganBulanan' => $dataLengkap
        ]);
    })->name('sekretariat.dashboard');

    // Admin Paramenta Dashboard
    Route::get('/paramenta/dashboard', function () {
        // Statistik Dinamis untuk Peminjaman Alat Misa
        $persetujuanAlat = PeminjamanAlatMisa::where('status_peminjaman', 'pending')->count();
        $peminjamanAktifAlat = PeminjamanAlatMisa::where('status_peminjaman', 'disetujui')->count();
        $totalPermintaanAlat = PeminjamanAlatMisa::count();

        // Data Grafik Peminjaman Alat Misa Bulanan
        $peminjamanAlatBulanan = PeminjamanAlatMisa::selectRaw('MONTH(created_at) as bulan, COUNT(*) as total')
            ->groupBy('bulan')
            ->orderBy('bulan')
            ->pluck('total', 'bulan');

        // Normalisasi Data Bulanan (1-12) dengan nilai 0 jika kosong
        $dataLengkap = array_fill(1, 12, 0);
        foreach ($peminjamanAlatBulanan as $bulan => $total) {
            $dataLengkap[$bulan] = $total;
        }

        // Kirim data ke view
        return view('layout.AdminParamentaView.HomeAdminParamenta', [
            'persetujuanAlat' => $persetujuanAlat,
            'peminjamanAktifAlat' => $peminjamanAktifAlat,
            'totalPermintaanAlat' => $totalPermintaanAlat,
            'peminjamanAlatBulanan' => $dataLengkap
        ]);
    })->name('paramenta.dashboard');

    // Rute untuk memproses persetujuan akun peminjam
    Route::post('/approve/{id}', [AuthController::class, 'approve'])->name('approve.peminjam');
});
