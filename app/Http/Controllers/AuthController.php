<?php

namespace App\Http\Controllers;

use App\Models\peminjam;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Mail;

use App\Mail\AccountRejectionMail;
use App\Mail\MailPenolakanAkun;

class AuthController extends Controller
{

    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|regex:/^[\w\.\-]+@gmail\.com$/i|',
            'tanggal_lahir' => 'required|date',
            'alamat' => 'required|string',
            'nomor_telepon' => 'required|string|max:15',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $validated['password'] = Hash::make($validated['password']);
        peminjam::create($validated);
        return redirect()->back()->with('message', 'Registrasi berhasil, menunggu persetujuan admin');
        // return response()->json(['message' => 'Registrasi berhasil, menunggu persetujuan admin']);
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');
        $borrower = peminjam::where('email', $request->email)->first();

        if ($borrower && Hash::check($request->password, $borrower->password)) {
            if (!$borrower->is_approved) {
                return response()->json(['message' => 'Akun belum disetujui oleh admin'], 403);
            }
            Auth::login($borrower);
            return response()->json(['message' => 'Login berhasil']);
        }
        return redirect()->back()->with('message', 'Username atau Password Anda Salah!');
        // return response()->json(['message' => 'Email atau kata sandi salah'], 401);
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
            return back()->withErrors(['email' => 'Email ini tidak terdaftar atau belum disetujui.']);
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
            'password' => 'required|string|min:8|confirmed',
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
            ? redirect()->route('login')->with('status', __($status))
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
