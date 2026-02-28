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
        Schema::create('comments', function (Blueprint $table) {
            $table->id()->unique();
            // Este post_id(int) deberia crearse como una FK de la tabla post pero lo dejo igual que el documento .sql
            $table->integer('post_id')->nullable();
            $table->foreignId('user_id')
                    ->constrained()
                    ->restrictOnDelete()
                    ->restrictOnUpdate();;
            $table->longText('content')->nullable();
            $table->timestamp('datetime')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('comments');
    }
};
