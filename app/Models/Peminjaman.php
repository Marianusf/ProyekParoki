<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class Peminjaman extends Model
{
    use HasFactory;

    protected $table = 'peminjamans';  // Tabel yang digunakan oleh model ini

    // Tentukan kolom mana yang boleh diisi massal
    protected $fillable = [
        'penanggung_jawab',
        'jenis_peminjaman',
        'asset_id',
        'jumlah',
        'ruangan_id',
        'tanggal_mulai',
        'tanggal_selesai',
        'jam_mulai',
        'jam_selesai',
    ];

}
