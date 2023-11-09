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
        Schema::create('products_files', function (Blueprint $table) {
            $table->id();

//            $table->foreignId('products_id')->constrained();
//            $table->foreignId('files_id')->constrained();
            $table->unsignedBigInteger('product_id');
            $table->unsignedBigInteger('files_id');
//
//
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
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
        Schema::dropIfExists('products_files');
    }
};
