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
        Schema::create('t_bagian_pemilu', function (Blueprint $table) {
            $table->id('id_bagian_pemilu'); // Primary key: id_bagian_pemilu
            $table->unsignedInteger('id_kabkota'); // Foreign key to kabkota table
            $table->enum('label', ['pilgub', 'pilwako', 'pilkab', 'NONE']);// Label field
            // $table->timestamps(); // Uncomment if you want to include created_at and updated_at columns

            // Adding a foreign key constraint for id_kabkota
            $table->foreign('id_kabkota')->references('id_kabkota')->on('wilayah_pemilu')->onDelete('restrict')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('t_bagian_pemilu');
    }
};
