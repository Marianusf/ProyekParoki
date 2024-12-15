<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Alat_Misa extends Model
{
    use HasFactory;
    protected $table = 'alat_misa'; // Nama tabel di database
    // Tentukan atribut yang dapat diisi dengan mass assignment
    protected $fillable = [
        'nama_alat',
        'jenis_alat',
        'deskripsi',
        'detail_alat',
        'jumlah',
        'kondisi',
        'jumlah_terpinjam',
        'gambar',
    ];
    // Menentukan tipe data kolom yang menggunakan JSON
    protected $casts = [
        'detail_alat' => 'array',
    ];

    public function keranjang()
    {
        return $this->hasMany(KeranjangAlatMisa::class, 'id_alatmisa');
    }

    // Relasi ke peminjaman
    public function peminjamanAlatMisa()
    {
        return $this->hasMany(PeminjamanAlatMisa::class, 'id_alatmisa');
    }
    // di dalam model Asset
    public function getStokTersediaAttribute()
    {
        return $this->jumlah - $this->jumlah_terpinjam;
    }
    // public function pengembalian()
    // {
    //     return $this->hasMany(Pengembalian::class); // Menghubungkan dengan model Pengembalian
    // }
}
