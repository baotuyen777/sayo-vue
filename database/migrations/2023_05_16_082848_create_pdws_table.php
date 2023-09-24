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
//        Schema::create('pdws', function (Blueprint $table) {
//            $table->id();
//            $table->string('code')->unique();
//            $table->string('name');
//            $table->tinyInteger('level')->default(1);
//            $table->integer('status')->default(1);
//
//            $table->unsignedBigInteger('parent_id')->default(1);
////            $table->foreign('parent_id')->references('id')->on('pdws')->onDelete('cascade');
//
//            $table->timestamps();
//        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pdws');
    }
};
