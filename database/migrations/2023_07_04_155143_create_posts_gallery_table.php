<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('posts_gallery', function (Blueprint $table) {
            $table->id();

//            $table->foreignId('posts_id')->constrained();
//            $table->foreignId('medias_id')->constrained();
            $table->unsignedBigInteger('posts_id');
            $table->unsignedBigInteger('medias_id');
//
//
            $table->foreign('posts_id')->references('id')->on('posts')->onDelete('cascade');
            $table->foreign('medias_id')->references('id')->on('medias')->onDelete('cascade');

            $table->string('type')->default('gallery');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('posts_gallery');
    }
};
