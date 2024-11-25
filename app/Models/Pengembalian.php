<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengembalian extends Model
{
    use HasFactory;
    protected $table = 'pengembalian';
    protected $fillable = [
        'peminjaman_id',
        'tanggal_pengembalian',
        'status',
        'alasan_penolakan',
    ];

    // Relasi ke peminjaman
    public function peminjaman()
    {
        return $this->belongsTo(Peminjaman::class);
    }
    public function pengembalian()
    {
        return $this->hasOne(Pengembalian::class); // Setiap peminjaman memiliki satu pengembalian
    }
    public function asset()
    {
        return $this->belongsTo(Asset::class, 'asset_id');
    }
    // Di model Pengembalian

    public function peminjam()
    {
        return $this->belongsTo(Peminjam::class);
    }
}
