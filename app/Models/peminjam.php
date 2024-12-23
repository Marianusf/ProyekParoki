<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class peminjam extends Authenticatable
{

    use HasFactory, Notifiable;
    protected $table = 'peminjam';
    protected $fillable = [
        'name',
        'email',
        'tanggal_lahir',
        'alamat',
        'nomor_telepon',
        'lingkungan',
        'password',
        'is_approved',
        'poto_profile'
    ];

    protected $hidden = [
        'password',
    ];

    public function pendingRequests()
    {
        return self::where('is_approved', false)->get();
    }
    // Relasi ke keranjang
    public function keranjang()
    {
        return $this->hasMany(Keranjang::class, 'id_peminjam');
    }

    // Relasi ke peminjaman
    public function peminjaman()
    {
        return $this->hasMany(Peminjaman::class, 'id_peminjaman');
    }
    // Relasi ke peminjaman
    public function pengembalian()
    {
        return $this->hasMany(pengembalian::class);
    }
}
