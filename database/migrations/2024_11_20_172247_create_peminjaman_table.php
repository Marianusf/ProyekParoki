<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePeminjamanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('peminjaman', function (Blueprint $table) {
            $table->id();
            $table->string('penanggung_jawab');
            $table->enum('jenis_peminjaman', ['asset', 'ruangan', 'alatMisa', 'perlengkapan']);
            $table->date('tanggal_mulai')->nullable();
            $table->date('tanggal_selesai')->nullable();
            $table->time('jam_mulai')->nullable();
            $table->time('jam_selesai')->nullable();
            $table->timestamps();
        });

        Schema::create('peminjaman_detail', function (Blueprint $table) {
            $table->id();
            $table->foreignId('peminjaman_id')->constrained('peminjaman')->onDelete('cascade');
            $table->bigInteger('item_id');
            $table->integer('jumlah')->nullable();
            $table->timestamps();
        });

        Schema::create('items', function (Blueprint $table) {
            $table->id();
            $table->string('nama_item');
            $table->enum('jenis', ['asset', 'alatMisa', 'perlengkapan']);
            $table->integer('stok');
            $table->string('gambar_path')->nullable();
            $table->timestamps();
        });
        Schema::create('keranjang', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_peminjam')->constrained('peminjam')->onDelete('cascade');
            $table->timestamps();
        });
        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('items');
        Schema::dropIfExists('peminjaman_detail');
        Schema::dropIfExists('peminjaman');
        Schema::dropIfExists('keranjang'); // Hapus tabel anak terlebih dahulu
        Schema::dropIfExists('peminjam');  // Kemudian hapus tabel induk
    }
}
