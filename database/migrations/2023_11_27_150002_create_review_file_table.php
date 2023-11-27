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
        Schema::create('review_file', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('review_id');
            $table->unsignedBigInteger('files_id');

            $table->foreign('review_id')->references('id')->on('product_review')->onDelete('cascade');
            $table->foreign('files_id')->references('id')->on('files')->onDelete('cascade');

            $table->string('type')->default('files');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('review_file', function ($table) {
            $table->dropForeign(['review_id']);
            $table->dropForeign(['files_id']);
        });
        Schema::dropIfExists('review_file');
    }
};
