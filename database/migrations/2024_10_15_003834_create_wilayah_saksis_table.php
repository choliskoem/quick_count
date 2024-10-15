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
        Schema::create('wilayah_saksi', function (Blueprint $table) {
            $table->string('id_wilayah_saksi', 255)->primary(); // Primary key: id_wilayah_saksi
            $table->unsignedInteger('id_kabkota'); // Indexed column: id_kabkota
            $table->unsignedInteger('id_wilayah'); // Indexed column: id_wilayah
            $table->string('kd_saksi', 255);            // Indexed column: kd_saksi
            $table->integer('id_tps'); // Indexed column: id_tps
            // $table->timestamps();

            // Adding indexes for relevant columns
            $table->foreign('id_kabkota')->references('id_kabkota')->on('wilayah_pemilu')->onDelete('restrict')->onUpdate('cascade');
            $table->foreign('id_wilayah')->references('id_wilayah')->on('t_wilayah')->onDelete('restrict')->onUpdate('cascade');
            $table->foreign('id_tps')->references('id_tps')->on('tps')->onDelete('restrict')->onUpdate('cascade');
            $table->foreign('kd_saksi')->references('kd_saksi')->on('t_saksi')->onDelete('restrict')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('wilayah_saksi');
    }
};
