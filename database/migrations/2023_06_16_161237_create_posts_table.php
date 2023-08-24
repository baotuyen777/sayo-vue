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
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('code')->unique();
            $table->text('content')->nullable();
            $table->tinyInteger('state')->default(1);
            $table->tinyInteger('status')->default(1);
            $table->bigInteger('price')->default(0);
            $table->string('address')->default(0);

            $table->json('attr')->nullable();

            $table->unsignedBigInteger('ward_id')->nullable();
            $table->foreign('ward_id')->references('id')->on('pdws')->onDelete('cascade');

            $table->unsignedBigInteger('district_id')->nullable();
            $table->foreign('district_id')->references('id')->on('pdws')->onDelete('cascade');

            $table->unsignedBigInteger('province_id')->nullable();
            $table->foreign('province_id')->references('id')->on('pdws')->onDelete('cascade');

            $table->unsignedBigInteger('avatar_id')->nullable();
            $table->foreign('avatar_id')->references('id')->on('medias')->onDelete('cascade');

            $table->unsignedBigInteger('video_id')->nullable();

            $table->unsignedBigInteger('category_id');
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');

            $table->unsignedBigInteger('author_id');
            $table->foreign('author_id')->references('id')->on('users')->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('posts', function (Blueprint $table) {
             $table->dropForeign(['ward_id']);
             $table->dropForeign(['district_id']);
             $table->dropForeign(['province_id']);
             $table->dropForeign(['avatar_id']);
             $table->dropForeign(['category_id']);
             $table->dropForeign(['author_id']);
        });
        Schema::dropIfExists('posts');
    }
};
