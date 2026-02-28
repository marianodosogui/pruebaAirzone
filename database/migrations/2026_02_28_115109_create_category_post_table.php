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
        Schema::create('category_post', function (Blueprint $table) {
        // Por como esta el documento .sql de la creacion de la BBDD añado el id de la tabla 
        // pero personalmente en las tablas de union o pivote soy partidario de dejar solo los ids de las tablas relacionadas
            $table->id()->unique();

            $table->foreignId('category_id')
                ->constrained()
                ->restrictOnDelete()
                ->restrictOnUpdate();;
            $table->foreignId('post_id')
                ->constrained()
                ->restrictOnDelete()
                ->restrictOnUpdate();;
            $table->primary(['id', 'category_id', 'post_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('category_post');
    }
};
