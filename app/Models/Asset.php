<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Asset extends Model
{
    use HasFactory;

    // Tentukan atribut yang dapat diisi dengan mass assignment
    protected $fillable = [
        'nama_barang',
        'jenis_barang',
        'jumlah_barang',
        'jumlah_terpinjam',
        'kondisi',
        'deskripsi',
        'gambar',
    ];

    // Atau jika Anda ingin menggunakan $guarded (untuk melindungi semua kolom, kecuali yang disebutkan)
    // protected $guarded = [];
    // Relasi ke keranjang peminjaman
    public function keranjang()
    {
        return $this->hasMany(Keranjang::class);
    }

    // Relasi ke peminjaman
    public function peminjaman()
    {
        return $this->hasMany(Peminjaman::class, 'asset_id');
    }
    // di dalam model Asset
    public function getStokTersediaAttribute()
    {
        return $this->jumlah_barang - $this->jumlah_terpinjam;
    }
}
