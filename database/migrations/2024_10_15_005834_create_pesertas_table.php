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
        Schema::create('t_peserta', function (Blueprint $table) {
            $table->id('id_peserta'); // Primary key: id_peserta
            $table->string('no_urut', 2); // Indexed column: no_urut
            $table->unsignedBigInteger('id_bagian_pemilu'); // Foreign key to bagian_pemilu table
            // $table->timestamps(); // Uncomment if you want to include created_at and updated_at columns

            // Adding a foreign key constraint for id_bagian_pemilu
            $table->foreign('id_bagian_pemilu')->references('id_bagian_pemilu')->on('t_bagian_pemilu')->onDelete('restrict')->onUpdate('cascade');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('t_peserta');
    }
};
