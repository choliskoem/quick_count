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
        Schema::create('t_wilayah', function (Blueprint $table) {
            $table->unsignedInteger('id_wilayah')->primary();
            $table->unsignedInteger('id_provinsi');
            $table->unsignedInteger('id_kabkota');
            $table->unsignedInteger('id_kecamatan');
            $table->unsignedInteger('id_desa');
            $table->string('nama_provinsi', 250)->nullable();
            $table->string('nama_kabkota', 250)->nullable();
            $table->string('nama_kecamatan', 250)->nullable();
            $table->string('nama_desa', 250)->nullable();
            // $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('t_wilayah');
    }
};
