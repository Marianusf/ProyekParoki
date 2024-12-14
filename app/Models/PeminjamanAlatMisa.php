<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PeminjamanAlatMisa extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_peminjam',
        'id_alatmisa',
        'id_admin',
        'nama',
        'jumlah',
        'tanggal_peminjaman',
        'tanggal_pengembalian',
        'status_peminjaman',
        'alasan_penolakan'
    ];


    // Relasi dengan peminjam
    public function peminjam()
    {
        return $this->belongsTo(Peminjam::class);
    }

    // Relasi dengan alat misa
    public function alatMisa()
    {
        return $this->belongsTo(AlatMisa::class);
    }
    public function admin()
    {
        return $this->belongsTo(Admin::class, 'id_admin');
    }
}