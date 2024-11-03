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
        'password',
        'is_approved',
    ];

    protected $hidden = [
        'password',
    ];

    public function pendingRequests()
    {
        return self::where('is_approved', false)->get();
    }
}
