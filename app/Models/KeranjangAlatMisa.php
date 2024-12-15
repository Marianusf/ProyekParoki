<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KeranjangAlatMisa extends Model
{
    use HasFactory;

    protected $table = 'keranjangalatmisa'; // Nama tabel untuk keranjang alat misa

    protected $fillable = [
        'id_peminjam',          // ID peminjam
        'id_alatmisa',         // ID alat misa
        'jumlah',               // Jumlah yang dipinjam
        'tanggal_peminjaman',   // Tanggal mulai peminjaman
        'tanggal_pengembalian'  // Tanggal pengembalian
    ];

    // Relasi ke peminjam
    public function peminjam()
    {
        return $this->belongsTo(Peminjam::class, 'id_peminjam');
    }

    // Relasi ke alat misa
    public function alatMisa()
    {
        return $this->belongsTo(Alat_Misa::class, 'id_alatmisa');
    }
}
