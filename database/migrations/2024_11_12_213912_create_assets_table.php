<?php
// database/migrations/xxxx_xx_xx_xxxxxx_create_assets_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAssetsTable extends Migration
{
    public function up()
    {
        Schema::create('assets', function (Blueprint $table) {
            $table->id();
            $table->string('nama_barang');
            $table->string('jenis_barang');
            $table->integer('jumlah_barang');
            $table->integer('jumlah_terpinjam')->default(0);
            $table->enum('kondisi', ['baik', 'rusak', 'perlu_perbaikan']);
            $table->text('deskripsi');
            $table->string('gambar')->nullable(); // Kolom untuk menyimpan nama file gambar
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('assets');
    }
}
