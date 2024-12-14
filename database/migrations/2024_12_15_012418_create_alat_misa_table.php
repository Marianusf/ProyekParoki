<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAlatMisaTable extends Migration
{
    public function up()
    {
        Schema::create('alat_misa', function (Blueprint $table) {
            $table->id();
            $table->string('nama_alat');
            $table->string('jenis_alat');
            $table->text('deskripsi')->nullable();
            $table->json('detail_alat')->nullable();
            $table->integer('jumlah');
            $table->enum('kondisi', ['baik', 'perbaikan']);
            $table->integer('jumlah_terpinjam')->default(0);
            $table->string('gambar')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('alat_misa');
    }
}
