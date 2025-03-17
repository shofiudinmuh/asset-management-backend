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
        Schema::create('assets', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->enum('category', ['Mesin', 'Kendaraan', 'Peralatan', 'Bahan Baku']);
            $table->string('serial_number');
            $table->date('purchase_date');
            $table->date('warranty_expiry')->nullable();
            $table->enum('status', ['Tersedia', 'Dipinjam', 'Dalam Perbaikan', 'Rusak']);
            $table->foreignId('location_id')->constrained()->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('assets');
    }
};