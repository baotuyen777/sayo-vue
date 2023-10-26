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
            $table->tinyInteger('state')->default(STATE_NEW)->comment('1: hang moi, 2: cu con bao hanh, 3: cu het bao hanh ');
            $table->tinyInteger('status')->default(STATUS_PENDING);
            $table->bigInteger('price')->default(0)->nullable();
            $table->string('address')->nullable();

            $table->json('attr')->nullable();
            $table->string('source')->nullable();
            $table->string('sell_type')->default(POST_TYPE_PROFESSIONAL);

            $table->unsignedBigInteger('province_id')->nullable();
            $table->foreign('province_id')->references('id')->on('provinces')->onDelete('cascade');

            $table->unsignedBigInteger('district_id')->nullable();
            $table->foreign('district_id')->references('id')->on('districts')->onDelete('cascade');

            $table->unsignedBigInteger('ward_id')->nullable();
            $table->foreign('ward_id')->references('id')->on('wards')->onDelete('cascade');

            $table->unsignedBigInteger('avatar_id')->nullable();
            $table->foreign('avatar_id')->references('id')->on('files')->onDelete('cascade');

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
