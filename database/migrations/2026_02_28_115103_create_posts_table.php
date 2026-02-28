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
        Schema::create('posts', function (Blueprint $table) {
            $table->id()->unique();
            $table->foreignId('user_id')
                    ->constrained()
                    ->restrictOnDelete()
                    ->restrictOnUpdate();
            $table->string('title', 128);
            $table->string('slug', 128);
            $table->string('picture', 128)->nullable();
            $table->text('short_content');
            $table->longText('content')->nullable();
            $table->dateTime('added');
            $table->timestamp('updated')
                    ->useCurrent()
                    ->useCurrentOnUpdate();
            $table->boolean('comment')->default(false);
            $table->boolean('pending')->default(false);
            $table->boolean('public')->default(true);
            $table->boolean('active')->default(true);

            $table->primary(['id', 'user_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('posts');
    }
};
