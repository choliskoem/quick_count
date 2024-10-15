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
        Schema::create('t_detail_peserta', function (Blueprint $table) {
            $table->id('id_detail_peserta'); // Primary key: id_detail_peserta
            $table->unsignedBigInteger('id_peserta'); // Foreign key to peserta table
            $table->string('nama_peserta', 250); // Column for participant name
            $table->integer('posisi'); // Indexed column: posisi
            // $table->timestamps(); // Uncomment if you want to include created_at and updated_at columns

            // Adding a foreign key constraint for id_peserta
            $table->foreign('id_peserta')->references('id_peserta')->on('t_peserta')->onDelete('restrict')->onUpdate('cascade');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('t_detail_peserta');
    }
};
