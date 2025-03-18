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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('asset_id')->contrained()->onDelete('cascade');
            $table->foreignId('user_id')->contrained()->onDelete('cascade');
            $table->enum('transaction_type', ['Pinjam', 'Kembalikan', 'Transfer']);
            $table->date('transaction_date');
            $table->foreignId('location_id')->contrained()->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};