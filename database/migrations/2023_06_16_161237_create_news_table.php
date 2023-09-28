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
        Schema::create('news', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('code')->unique();
            $table->text('content')->nullable();
            $table->unsignedBigInteger('category_id')->nullable();
            $table->string('avatar_link')->nullable();
            $table->unsignedBigInteger('avatar_id')->nullable();
            $table->foreign('avatar_id')->references('id')->on('files')->onDelete('cascade');

            $table->unsignedBigInteger('author_id')->nullable();
            $table->foreign('author_id')->references('id')->on('users')->onDelete('cascade');

            $table->tinyInteger('state')->default(1)->comment('1: hang moi, 2: cu con bao hanh, 3: cu het bao hanh ');
            $table->tinyInteger('status')->default(1);
            $table->timestamps();

            $table->index(['code', 'updated_at']);
        });
//        \Illuminate\Support\Facades\Artisan::call('news:import');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('news', function (Blueprint $table) {
             $table->dropForeign(['avatar_id']);
             $table->dropForeign(['author_id']);
        });
        Schema::dropIfExists('news');
    }
};
