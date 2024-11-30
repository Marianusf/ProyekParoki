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
        Schema::create('peminjam', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Nama peminjam
            $table->string('email')->unique(); // Email peminjam
            $table->date('tanggal_lahir'); // Tanggal lahir peminjam
            $table->string('alamat'); // Alamat peminjam
            $table->string('nomor_telepon'); // Nomor telepon peminjam
            $table->string('lingkungan'); // nama lingkungan
            $table->string('password'); // Kata sandi
            $table->boolean('is_approved')->default(false); // Status persetujuan dari admin
            $table->string('poto_profile')->default('default.jpg'); // poto profile
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('peminjam');
    }
};
