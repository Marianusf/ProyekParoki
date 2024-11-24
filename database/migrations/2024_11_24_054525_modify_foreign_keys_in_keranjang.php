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
        Schema::table('keranjang', function (Blueprint $table) {
            $table->dropForeign(['id_peminjam']); // Hapus foreign key lama
            $table->foreign('id_peminjam')->references('id')->on('peminjam')->onDelete('cascade'); // Tambahkan ulang dengan opsi cascade
        });
    }
    
    public function down()
    {
        Schema::table('keranjang', function (Blueprint $table) {
            $table->dropForeign(['id_peminjam']); // Hapus foreign key baru
            $table->foreign('id_peminjam')->references('id')->on('peminjam'); // Tambahkan kembali tanpa cascade
        });
    }
    
};
