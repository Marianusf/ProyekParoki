<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KeranjangPeminjaman extends Model
{
    use HasFactory;

    // Tentukan nama tabel yang sesuai (jika berbeda dengan default nama tabel)
    protected $table = 'keranjang_peminjaman';

    // Tentukan kolom-kolom yang dapat diisi (mass assignable)
    protected $fillable = [
        'penanggung_jawab', 
        'jenis_peminjaman', 
        'alat_misa', 
        'perlengkapan', 
        'ruangan', 
        'tanggal_mulai', 
        'tanggal_selesai', 
        'jam_mulai', 
        'jam_selesai', 
        'jumlah',
        'status'
    ];

    // Jika Anda menggunakan timestamps (created_at, updated_at)
    public $timestamps = true;

    // Jika menggunakan status yang default, Anda bisa menetapkan nilai default
    protected $attributes = [
        'status' => 'menunggu persetujuan',  // Default status
    ];
}
