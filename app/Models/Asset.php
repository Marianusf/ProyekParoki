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
        'kondisi',
        'gambar',
    ];

    // Atau jika Anda ingin menggunakan $guarded (untuk melindungi semua kolom, kecuali yang disebutkan)
    // protected $guarded = [];
}
