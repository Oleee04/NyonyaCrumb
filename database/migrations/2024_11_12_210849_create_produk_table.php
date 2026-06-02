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
        Schema::create('produk', function (Blueprint $table) {
            $table->id();
            $table->boolean('status');
            $table->string('nama_produk');
            $table->text('detail');
            $table->double('harga');
            $table->integer('stok');
            $table->float('berat');
            $table->string('foto');

            // 
            $table->unsignedBigInteger('kategori_id');
            $table->unsignedBigInteger('user_id');

            $table->timestamps();

            // 
            $table->foreign('kategori_id')->references('id')->on('kategori')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('produk');
    }
};
