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
        Schema::create('t_saksi', function (Blueprint $table) {
            $table->string('kd_saksi', 255)->primary();
            $table->string('nama_saksi', 200);
            $table->string('no_hp', 50);
            // $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('t_saksi');
    }
};
