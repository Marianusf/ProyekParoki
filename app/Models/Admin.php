<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class Admin extends Model
{
    use HasFactory;

    protected $table = 'admin'; // Nama tabel di database

    protected $fillable = [
        'nama',
        'email',
        'nomor_telepon',
        'password',
        'role',
    ];

    // Jika Anda menggunakan hashing untuk password
    protected $hidden = [
        'password',
    ];
}
