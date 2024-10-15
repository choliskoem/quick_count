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
        Schema::create('wilayah_pemilu', function (Blueprint $table) {
            $table->unsignedInteger('id_kabkota')->primary(); // Primary key: id_kabkota
            $table->string('wilayah', 250); // Indexed column: wilayah
            // $table->timestamps();

            // Adding an index for 'wilayah'
            $table->index('wilayah');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('wilayah_pemilu');
    }
};
