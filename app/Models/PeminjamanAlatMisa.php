<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PeminjamanAlatMisa extends Model
{
    use HasFactory;
    protected $table = 'peminjaman_alat_misa'; // Penamaan tabel yang benar
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


    // app/Models/PeminjamanAlatMisa.php
    public function alatMisa()
    {
        return $this->belongsTo(Alat_Misa::class, 'id_alatmisa', 'id');
    }

    public function peminjam()
    {
        return $this->belongsTo(peminjam::class, 'id_peminjam', 'id');
    }

    public function admin()
    {
        return $this->belongsTo(Admin::class, 'id_admin');
    }
}
