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
        // Tambahkan kolom size jika tabel order_item sudah ada
        if (Schema::hasTable('order_item')) {
            if (!Schema::hasColumn('order_item', 'size')) {
                Schema::table('order_item', function (Blueprint $table) {
                    $table->string('size')->nullable()->after('produk_id');
                });
            }
            
            // Hapus kolom hp dari order_item jika ada (karena hp seharusnya di tabel orders)
            if (Schema::hasColumn('order_item', 'hp')) {
                Schema::table('order_item', function (Blueprint $table) {
                    $table->dropColumn('hp');
                });
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('order_item')) {
            if (Schema::hasColumn('order_item', 'size')) {
                Schema::table('order_item', function (Blueprint $table) {
                    $table->dropColumn('size');
                });
            }
        }
    }
};