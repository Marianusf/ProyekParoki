<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class PeminjamanRuangan extends Model
{
    use HasFactory;

    protected $table = 'peminjaman_ruangan';
    protected $dates = ['tanggal_mulai', 'tanggal_selesai'];

    protected $fillable = [
        'ruangan_id',
        'peminjam_id',
        'admin_id',
        'tanggal_mulai',
        'tanggal_selesai',
        'status_peminjaman',
        'alasan_penolakan',
    ];
    // Relasi ke Ruangan
    public function ruangan()
    {
        return $this->belongsTo(Ruangan::class);
    }

    // Relasi ke Peminjam
    public function peminjam()
    {
        return $this->belongsTo(Peminjam::class);
    }

    // Relasi ke Admin
    public function admin()
    {
        return $this->belongsTo(Admin::class);
    }
}
