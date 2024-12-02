<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Keranjang extends Model
{
    use HasFactory;

    protected $table = 'keranjang';

    protected $fillable = [
        'id_peminjam',
        'id_asset',
        'jumlah',
        'tanggal_peminjaman',
        'tanggal_pengembalian'
    ];

    // Relasi ke peminjam
    public function peminjam()
    {
        return $this->belongsTo(peminjam::class, 'id_peminjam');
    }

    // Relasi ke asset
    public function asset()
    {
        return $this->belongsTo(Assets::class, 'id_asset');
    }
}
