<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ruangan extends Model
{
    use HasFactory;

    // Menentukan nama tabel yang digunakan
    protected $table = 'ruangan';

    // Menentukan atribut yang dapat diisi (mass assignable)
    protected $fillable = [
        'nama',
        'kapasitas',
        'deskripsi',
        'kondisi',
        'status',
        'fasilitas',
    ];

    // Menentukan tipe data kolom yang menggunakan JSON
    protected $casts = [
        'fasilitas' => 'array', // Mengonversi kolom fasilitas menjadi array
    ];
}
