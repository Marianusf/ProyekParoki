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
        'id_admin',
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
        return $this->belongsTo(Assets::class, 'id_asset');
    }
    public function pengembalian()
    {
        return $this->hasOne(Pengembalian::class, 'peminjaman_id'); // Properly relate via peminjaman_id
    }
    public function admin()
    {
        return $this->belongsTo(Admin::class, 'id_admin');
    }
}
