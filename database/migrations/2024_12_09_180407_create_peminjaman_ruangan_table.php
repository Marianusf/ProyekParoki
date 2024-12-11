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
        Schema::create('peminjaman_ruangan', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('ruangan_id');
            $table->unsignedBigInteger('peminjam_id');
            $table->unsignedBigInteger('admin_id')->nullable(); // Null until approved/rejected
            $table->dateTime('tanggal_mulai'); // Start date and time
            $table->dateTime('tanggal_selesai'); // End date and time
            $table->enum('status_peminjaman', ['pending', 'disetujui', 'ditolak', 'selesai'])->default('pending');
            $table->text('alasan_penolakan')->nullable(); // Reason for rejection
            $table->timestamps();

            // Foreign keys
            $table->foreign('ruangan_id')->references('id')->on('ruangan')->onDelete('cascade');
            $table->foreign('peminjam_id')->references('id')->on('peminjam')->onDelete('cascade');
            $table->foreign('admin_id')->references('id')->on('admin')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('peminjaman_ruangan');
    }
};
