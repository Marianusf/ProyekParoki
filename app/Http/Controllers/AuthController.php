<?php

namespace App\Http\Controllers;

use App\Models\peminjam;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;

use App\Mail\AccountRejectionMail;
use App\Mail\MailPenolakanAkun;
use App\Mail\MailTerimaPendaftaran;

class AuthController extends Controller
{

    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|regex:/^[\w\.\-]+@gmail\.com$/i|unique:peminjam,email',
            'tanggal_lahir' => 'required|date',
            'alamat' => 'required|string',
            'nomor_telepon' => 'required|numeric|digits_between:10,15', // Hanya angka
            'lingkungan' => 'required|string',
            'password' => [
                'required',
                'string',
                'min:8',
                'confirmed',
                'regex:/^(?=.*[0-9]).{8,}$/', // Minimal 8 karakter dengan minimal 1 angka
            ],
        ], [
            'email.unique' => 'Email ini sudah terdaftar, silakan gunakan email lain.',
            'name.required' => 'Nama Anda wajib untuk diisi!!',
            'email.required' => 'Email Anda wajib diisi !',
            'tanggal_lahir' => 'Tanggal Lahir Wajib Untuk diisi!!',
            'nomor_telepon' => 'Nomor Telepon Anda Wajib Diisi dengan Angka 10-15 digit !',
            'lingkungan' => 'Nama lingkungan Wajib Untuk diisi dengan benar!',
            'password' => 'Password Minimal Memiliki 8 Karakter dengan Kombinasi Angka Minimal Satu',
            'email.email' => 'Format email tidak valid. example@gmail.com',
            'password.confirmed' => 'Konfirmasi kata sandi tidak sama !!',
        ]);

        // Hash password sebelum menyimpannya di database
        $validated['password'] = Hash::make($validated['password']);

        // Buat data baru di tabel `peminjam`
        peminjam::create($validated);

        return redirect()->back()->with('message', 'Permintaan Registrasi berhasil !,Silahkan Lihat Gmail untuk Informasi Lebih Lanjut');
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        // Cek apakah user adalah admin atau sekretariat terlebih dahulu
        $admin = Admin::where('email', $request->email)->first();

        if ($admin && Hash::check($request->password, $admin->password)) {
            Auth::guard('admin')->login($admin);

            // Cek role dan arahkan ke dashboard yang sesuai
            if ($admin->role === 'admin') {
                return redirect()->route('admin.dashboard')->with('message', 'Login berhasil sebagai Admin');
            } elseif ($admin->role === 'sekretariat') {
                return redirect()->route('sekretariat.dashboard')->with('message', 'Login berhasil sebagai Sekretariat');
            } elseif ($admin->role === 'paramenta') {
                return redirect()->route('paramenta.dashboard')->with('message', 'Login berhasil sebagai Paramenta');
            }
        }

        // Jika bukan admin atau sekretariat, cek peminjam
        $borrower = Peminjam::where('email', $request->email)->first();

        if ($borrower && Hash::check($request->password, $borrower->password)) {
            if (!$borrower->is_approved) {
                return redirect()->back()->with('error', 'Akun belum disetujui oleh admin. Mohon cek email pendaftar secara berkala.');
            }

            // Login peminjam
            Auth::guard('peminjam')->login($borrower);

            // Pembersihan keranjang peminjam yang lebih dari 24 jam ini tujuannya agar tidak berantakan lah boy
            DB::table('keranjang')
                ->where('id_peminjam', $borrower->id)  // Pastikan keranjang milik peminjam yang login
                ->where('created_at', '<', now()->subDay(1))  // Hapus yang lebih dari 24 jam
                ->delete();

            // Redirect ke dashboard peminjam
            return redirect()->route('peminjam.dashboard')->with('message', 'Login berhasil sebagai Peminjam');
        }

        // Jika tidak ada yang cocok, tampilkan pesan error
        return redirect()->back()->with('error', 'Username atau Password Anda Salah!');
    }




    public function showLinkRequestForm()
    {
        return view('auth.passwords.email');
    }

    public function sendResetLinkEmail(Request $request)
    {
        // Validate the incoming request
        $request->validate([
            'email' => 'required|email|regex:/^[\w\.\-]+@gmail\.com$/i|exists:peminjam,email',
        ]);

        // Check if the user exists and is approved
        $peminjam = peminjam::where('email', $request->email)->first();
        if (!$peminjam || !$peminjam->is_approved) {
            return back()->withErrors(['email' => 'Email ini tidak terdaftar atau belum disetujui,sehingga tidak dapat diproses!!']);
        }

        // Send the password reset email
        $status = Password::broker('peminjam')->sendResetLink($request->only('email'));

        return $status === Password::RESET_LINK_SENT
            ? back()->with('status', __($status))
            : back()->withErrors(['email' => __($status)]);
    }


    // Menampilkan formulir reset password
    public function showResetForm(Request $request, $token = null)
    {
        return view('auth.passwords.reset')->with(
            ['token' => $token, 'email' => $request->email]
        );
    }

    // Mengatur ulang password
    public function reset(Request $request)
    {
        $request->validate([
            'email' => 'required|email|regex:/^[\w\.\-]+@gmail\.com$/',
            'password' => [
                'required',
                'string',
                'min:8',
                'confirmed',
                'regex:/^(?=.*[0-9]).{8,}$/', // Minimal 8 karakter dengan minimal 1 angka
            ],
            'token' => 'required',
        ]);

        // Mengatur ulang password
        $status = Password::broker('peminjam')->reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($peminjam) use ($request) {
                $peminjam->password = bcrypt($request->password);
                $peminjam->save();
            }
        );

        return $status === Password::PASSWORD_RESET
            ? redirect()->route('login')->with('message', 'Password berhasil direset, silakan login dengan password baru Anda.')
            : back()->withErrors(['email' => __($status)]);
    }
    public function showApprovalRequests() //untuk menampilkan bagian peminjam yang belum di acc
    {
        // Ambil data peminjam yang belum disetujui
        $pendingRequest = Peminjam::where('is_approved', false)->get();

        // kirim data untuk menampilkan view yang belum di acc akunnya
        return view('layout.AdminView.LihatPermintaanAkun', ['pendingRequest' => $pendingRequest]);
    }

    public function approve($id)
    {
        // Cari peminjam berdasarkan ID
        $peminjam = Peminjam::findOrFail($id);

        // Update status peminjam menjadi approved (misal, `is_approved` jadi `1`)
        $peminjam->is_approved = 1;
        $peminjam->save();
        Mail::to($peminjam->email)->send(new MailTerimaPendaftaran($peminjam));
        // Redirect dengan pesan sukses
        return redirect()->back()->with('success', 'Akun peminjam berhasil disetujui.');
    }


    public function rejectAccount(Request $request, $id) //untuk proses penolakan akun
    {
        // Find the borrower
        $peminjam = Peminjam::findOrFail($id);

        // Send rejection email
        Mail::to($peminjam->email)->send(new MailPenolakanAkun($request->reason));

        return response()->json(['success' => true]);
    }
}
