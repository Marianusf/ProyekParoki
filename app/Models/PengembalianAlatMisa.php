<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PengembalianAlatMisa extends Model
{
    use HasFactory;

    // Nama tabel di database
    protected $table = 'pengembalian_alat_misa';

    // Kolom yang boleh diisi (mass assignable)
    protected $fillable = [
        'id_admin',
        'peminjaman_id',
        'tanggal_pengembalian',
        'status',
        'alasan_penolakan',
    ];

    /**
     * Relasi ke tabel Admin (nullable).
     * Jika id_admin NULL, relasi tetap aman.
     */
    public function admin()
    {
        return $this->belongsTo(Admin::class, 'id_admin');
    }



    /**
     * Relasi ke tabel Peminjaman.
     * Setiap pengembalian terhubung ke peminjaman tertentu.
     */
    public function peminjaman()
    {
        return $this->belongsTo(PeminjamanAlatMisa::class, 'peminjaman_id');
    }

    /**
     * Scope untuk filter pengembalian berdasarkan status.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param string $status
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    /**
     * Accessor untuk menampilkan status dengan format title case.
     *
     * @return string
     */
    public function getFormattedStatusAttribute()
    {
        return ucfirst($this->status); // Contoh: pending -> Pending
    }
}
