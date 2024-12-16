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
        Schema::create('pengembalian_alat_misa', function (Blueprint $table) {
            $table->id(); // Primary Key
            $table->unsignedBigInteger('id_admin')->nullable(); // Kolom id_admin
            $table->foreignId('peminjaman_id')->constrained('peminjaman_alat_misa')->onDelete('cascade'); // Relasi ke tabel peminjaman
            $table->foreign('id_admin')->references('id')->on('admin')->onDelete('set null'); // Relasi ke tabel admin
            $table->date('tanggal_pengembalian'); // Kolom tanggal pengembalian
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending'); // Status pengembalian
            $table->text('alasan_penolakan')->nullable(); // Alasan penolakan
            $table->timestamps(); // Kolom created_at dan updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengembalian_alat_misa');
    }
};
