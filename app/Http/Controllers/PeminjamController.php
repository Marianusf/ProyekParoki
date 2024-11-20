<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PeminjamController extends Controller
{
    public function index()
    {
        return view('PeminjamView.ViewRuangan'); // Ensure this view exists
    }
  
public function DaftarRuangan(){
    return View('FormRuangan');
}
public function Dashboard(){
    return View('PeminjamView.DashboardPeminjam');
}
public function InformasiRuangan(){
    return view('PeminjamView.InformasiRuangan');
}

public function EditAdmin(){
    return view('PeminjamView.AdminEdit');
}




//Menyimpan inputan data peminjaman ruangan 
public function SaveDataRuangan(Request $request)
    {
        // Validasi data
        $validatedData = $request->validate([
            'penanggung_jawab' => 'required|string|max:255',
            'tanggal_mulai' => 'required|date_format:d/m/Y',
            'tanggal_selesai' => 'required|date_format:d/m/Y',
            'jam_mulai' => 'required|date_format:H:i',
            'jam_selesai' => 'required|date_format:H:i',
            'keperluan' => 'required|string',
        ]);
    }
    



        // Simpan data ke dalam database
       
        public function tambahKeKeranjang(Request $request)
        {
            $request->validate([
                'id_asset' => 'required|exists:assets,id',
                'jumlah' => 'required|integer|min:1',
                'tanggal_peminjaman' => 'required|date',
                'tanggal_pengembalian' => 'required|date|after:tanggal_peminjaman',
            ]);
    
            // Ambil data asset dari database
            $asset = Asset::find($request['id_asset']);
    
            // Hitung stok yang tersedia
            $stokTersedia = $asset->jumlah_barang - $asset->jumlah_terpinjam;
    
            // Cek apakah jumlah yang diminta melebihi stok yang tersedia
            if ($request['jumlah'] > $stokTersedia) {
                return redirect()->back()->withErrors(['jumlah' => 'Stok tidak cukup untuk jumlah yang diminta.']);
            }
    
            // Tambahkan ke keranjang
            Keranjang::create([
                'id_peminjam' => auth()->guard('peminjam')->id(),
                'id_asset' => $request->id_asset,
                'jumlah' => $request->jumlah,
                'tanggal_peminjaman' => $request->tanggal_peminjaman,
                'tanggal_pengembalian' => $request->tanggal_pengembalian,
            ]);
    
            return redirect()->back()->with('success', 'Asset berhasil ditambahkan ke keranjang.');
        }
    
    
        // Fungsi untuk melihat isi keranjang
        public function lihatKeranjang()
        {
            $keranjangItems = Keranjang::where('id_peminjam', auth()->guard('peminjam')->id())->with('asset')->get();
    
            return view('layout.PeminjamView.LihatKeranjang', compact('keranjangItems'));
        }
        public function prosesCheckout(Request $request)
        {
            // Validasi item yang dipilih untuk checkout
            $selectedItems = $request->input('selected_items', []);
            if (empty($selectedItems)) {
                return redirect()->back()->with('error', 'Pilih setidaknya satu item untuk checkout.');
            }
    
            $errors = [];
    
            // Proses checkout untuk setiap item yang dipilih
            foreach ($selectedItems as $itemId) {
                $item = Keranjang::find($itemId);
    
                // Menghitung stok yang tersedia
                $stokTersedia = $item->asset->jumlah_barang - $item->asset->jumlah_terpinjam;
    
                // Validasi stok cukup
                if ($item->jumlah > $stokTersedia) {
                    $errors[] = "Stok untuk {$item->asset->nama_barang} tidak mencukupi. Tersedia: {$stokTersedia}, Dibutuhkan: {$item->jumlah}.";
                    continue;
                }
    
                // Jika stok cukup, simpan peminjaman dengan status menunggu persetujuan
                Peminjaman::create([
                    'id_peminjam' => auth()->guard('peminjam')->id(),
                    'id_asset' => $item->id_asset,
                    'jumlah' => $item->jumlah,
                    'tanggal_peminjaman' => $item->tanggal_peminjaman,
                    'tanggal_pengembalian' => $item->tanggal_pengembalian,
                    'status' => 'pending', // Status menunggu persetujuan admin
                ]);
            }
    
            // Jika ada error stok, kembali ke keranjang dengan pesan error
            if (!empty($errors)) {
                return redirect()->back()->withErrors($errors);
            }
    
            // Hapus item dari keranjang setelah checkout
            Keranjang::whereIn('id', $selectedItems)->delete();
    
            return redirect()->route('riwayatPeminjaman')->with('success', 'Checkout berhasil! Menunggu persetujuan admin.');
        }
    
    
    
        public function setujuiPeminjaman($id)
        {
            // Ambil data peminjaman dan asset
            $peminjaman = Peminjaman::findOrFail($id);
            $asset = Asset::findOrFail($peminjaman->id_asset);
    
            // Cek jika stok tersedia
            $stokTersedia = $asset->jumlah_barang - $asset->jumlah_terpinjam;
    
            // Jika jumlah barang yang dipinjam melebihi stok yang tersedia, batalkan
            if ($peminjaman->jumlah > $stokTersedia) {
                return redirect()->back()->withErrors(['jumlah' => 'Stok tidak cukup untuk memproses peminjaman.']);
            }
    
            // Update jumlah terpinjam di asset
            $asset->increment('jumlah_terpinjam', $peminjaman->jumlah);
    
            // Update status peminjaman menjadi disetujui
            $peminjaman->update(['status_peminjaman' => 'disetujui']);
    
            return redirect()->back()->with('success', 'Peminjaman berhasil disetujui.');
        }
    
    
        public function kembalikanAsset($id)
        {
            $peminjaman = Peminjaman::findOrFail($id);
            $asset = Asset::findOrFail($peminjaman->id_asset);
    
            // Update jumlah barang yang tersedia
            $asset->decrement('jumlah_terpinjam', $peminjaman->jumlah);
            $asset->increment('jumlah_barang', $peminjaman->jumlah);
    
            // Update status peminjaman menjadi dikembalikan
            $peminjaman->update(['status_peminjaman' => 'dikembalikan']);
    
            return redirect()->back()->with('success', 'Barang berhasil dikembalikan.');
        }
    
    
    
        // Fungsi untuk admin menolak permintaan peminjaman
        public function tolakPeminjaman(Request $request, $id)
        {
            $request->validate([
                'alasan_penolakan' => 'required|string'
            ]);
    
            $peminjaman = Peminjaman::findOrFail($id);
            $peminjaman->update([
                'status_peminjaman' => 'ditolak',
                'alasan_penolakan' => $request->alasan_penolakan
            ]);
    
            return redirect()->back()->with('success', 'Peminjaman ditolak.');
        }
        public function lihatRiwayatPeminjaman()
        {
            // Ambil riwayat peminjaman untuk peminjam yang sedang login
            $riwayatPeminjaman = Peminjaman::where('id_peminjam', auth()->guard('peminjam')->id())
                ->with('asset') // Mengambil informasi tentang asset yang dipinjam
                ->get();
    
            return view('layout.PeminjamView.RiwayatPeminjaman', compact('riwayatPeminjaman'));
        }
        public function tampilPinjamAsset()
        {
            $asset = Asset::where('kondisi', 'baik')->get();
            return view('layout.PeminjamView.PinjamAsset', compact('asset'));
        }
    }


  



