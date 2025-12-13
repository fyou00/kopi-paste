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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('nama_pelanggan');
            $table->foreignId('table_id')->nullable()->constrained('tables')->nullOnDelete();
            $table->enum('status', ['menunggu', 'diproses', 'selesai'])->default('menunggu');
            $table->integer('total');
            $table->timestamp('waktu')->useCurrent();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
