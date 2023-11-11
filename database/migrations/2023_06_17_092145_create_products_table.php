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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('code')->unique();
            $table->text('content')->nullable();
            $table->tinyInteger('state')->default(STATE_NEW)->comment('1: hang moi, 2: cu con bao hanh, 3: cu het bao hanh ');
            $table->tinyInteger('status')->default(STATUS_PENDING);
            $table->bigInteger('price')->default(0)->nullable();

            $table->json('attr')->nullable();
            $table->string('source')->nullable();

            $table->unsignedBigInteger('avatar_id')->nullable();
            $table->foreign('avatar_id')->references('id')->on('files')->onDelete('set null');

            $table->unsignedBigInteger('video_id')->nullable();

            $table->unsignedBigInteger('category_id')->nullable();
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('set null');

            $table->unsignedBigInteger('author_id')->nullable();
            $table->foreign('author_id')->references('id')->on('users')->onDelete('set null');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropForeign(['avatar_id']);
            $table->dropForeign(['category_id']);
            $table->dropForeign(['author_id']);
        });
        Schema::dropIfExists('products');
    }
};
