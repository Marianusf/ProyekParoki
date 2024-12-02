<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('ruangan', function (Blueprint $table) {
            $table->id(); // Primary key
            $table->string('nama', 100); // Nama ruangan
            $table->integer('kapasitas'); // Kapasitas ruangan (jumlah orang)
            $table->string('deskripsi', 1000);
            $table->enum('kondisi', ['baik', 'dalam_perbaikan'])->default('baik'); // Status ruangan
            $table->enum('status', ['tersedia', 'dipinjam', 'tidak_dapat_dipinjam'])->default('tersedia'); // Status ruangan
            $table->json('fasilitas')->nullable(); // Fasilitas dalam format JSON
            $table->string('gambar')->nullable();
            $table->timestamps(); // Timestamps (created_at, updated_at)
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ruangan');
    }
};
