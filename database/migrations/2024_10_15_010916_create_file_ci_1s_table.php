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
        Schema::create('t_file_ci_1', function (Blueprint $table) {
            $table->string('id_file', 255)->primary(); // Primary key: id_file
            $table->string('url_file', 255); // Column for file URL
            $table->string('id_wilayah_saksi'); // Indexed column: id_wilayah_saksi
            // $table->timestamps(); // Uncomment if you want to include created_at and updated_at columns

            // Adding a foreign key constraint for id_wilayah_saksi
            $table->foreign('id_wilayah_saksi')->references('id_wilayah_saksi')->on('wilayah_saksi')->onDelete('restrict')->onUpdate('cascade');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ft_ile_ci_1');
    }
};
