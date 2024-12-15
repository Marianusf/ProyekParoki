<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('keranjangalatmisa', function (Blueprint $table) {
            $table->id(); // Primary key (AUTO_INCREMENT)
            $table->unsignedBigInteger('id_peminjam'); // Foreign key ke peminjam
            $table->unsignedBigInteger('id_alatmisa'); // Foreign key ke alat misa
            $table->integer('jumlah'); // Jumlah alat yang dipinjam
            $table->date('tanggal_peminjaman'); // Tanggal mulai peminjaman
            $table->date('tanggal_pengembalian'); // Tanggal pengembalian
            $table->timestamps(); // Kolom created_at dan updated_at

            // Tambahkan foreign key constraints
            $table->foreign('id_peminjam')->references('id')->on('peminjam')->onDelete('cascade');
            $table->foreign('id_alatmisa')->references('id')->on('alat_misa')->onDelete('cascade');
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('keranjangalatmisa');
    }
};
