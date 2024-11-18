<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Peminjaman extends Model
{
    use HasFactory;

    protected $table = 'peminjaman';

    protected $fillable = [
        'id_peminjam',
        'id_asset',
        'jumlah',
        'tanggal_peminjaman',
        'tanggal_pengembalian',
        'status_peminjaman',
        'alasan_penolakan'
    ];

    // Relasi ke peminjam
    public function peminjam()
    {
        return $this->belongsTo(peminjam::class, 'id_peminjam');
    }

    // Relasi ke asset
    public function asset()
    {
        return $this->belongsTo(Asset::class, 'id_asset');
    }
}
