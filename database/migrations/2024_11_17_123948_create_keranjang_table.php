<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('keranjang', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_peminjam');
            $table->unsignedBigInteger('id_asset');
            $table->integer('jumlah');
            $table->date('tanggal_peminjaman');
            $table->date('tanggal_pengembalian');
            $table->timestamps();

            $table->foreign('id_peminjam')->references('id')->on('peminjam')->onDelete('cascade');
            $table->foreign('id_asset')->references('id')->on('assets')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('keranjang');
    }
};
