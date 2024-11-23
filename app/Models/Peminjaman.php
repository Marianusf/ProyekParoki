<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Peminjaman extends Model
{
    use HasFactory;

    protected $fillable = [
        'penanggung_jawab', 'jenis_peminjaman', 'tanggal_mulai', 'tanggal_selesai', 
        'jam_mulai', 'jam_selesai', 'asset_id', 'ruangan_id', 'alat_misa_id', 'perlengkapan_id', 
        'jumlah', 'status', 'approved_by', 'approved_at'
    ];

    // Fungsi untuk memeriksa apakah peminjaman sudah disetujui
    public function isApproved()
    {
        return $this->status === 'disetujui';
    }

    // Fungsi untuk memeriksa apakah peminjaman ditolak
    public function isRejected()
    {
        return $this->status === 'ditolak';
    }
}
