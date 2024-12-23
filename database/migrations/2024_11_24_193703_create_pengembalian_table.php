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
        Schema::create('pengembalian', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_admin')->nullable();
            $table->foreignId('peminjaman_id')->constrained('peminjaman')->onDelete('cascade'); // Relasi ke peminjaman
            $table->foreign('id_admin')->references('id')->on('admin')->onDelete('set null');
            $table->date('tanggal_pengembalian');
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->text('alasan_penolakan')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('pengembalian');
    }
};
