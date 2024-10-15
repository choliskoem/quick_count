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
        Schema::create('t_count', function (Blueprint $table) {
            $table->unsignedBigInteger('id_peserta'); // Indexed column: id_peserta
            $table->string('id_wilayah_saksi'); // Indexed column: id_wilayah_saksi
            $table->integer('jumlah'); // Column for the amount
            $table->enum('status', ['0', '1']); // Column for status with enum values
            // $table->timestamps(); // Uncomment if you want to include created_at and updated_at columns

            // Adding foreign key constraints
            $table->foreign('id_peserta')->references('id_peserta')->on('t_peserta')->onDelete('restrict')->onUpdate('cascade');
            $table->foreign('id_wilayah_saksi')->references('id_wilayah_saksi')->on('wilayah_saksi')->onDelete('restrict')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('t_count');
    }
};
