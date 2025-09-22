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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique()->index();
            $table->tinyInteger('status')->default(1);
            $table->enum('state', ['init', 'processing', 'delivery', 'completed', 'refund', ' cancel'])->default('init');
            $table->bigInteger('price')->default(0)->nullable();

            $table->unsignedBigInteger('author_id')->nullable();
            $table->foreign('author_id')->references('id')->on('users')->onDelete('set null');

            $table->unsignedBigInteger('product_id')->nullable();
            $table->foreign('product_id')->references('id')->on('products')->onDelete('set null');
            // ko nên cascade để phục vụ báo cáo
            $table->unsignedBigInteger('seller_id')->nullable();
            $table->foreign('seller_id')->references('id')->on('users')->onDelete('set null');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //        Schema::table('orders', function (Blueprint $table) {
        //            $table->dropForeign(['product_id']);
        //            $table->dropForeign(['author_id']);
        //            $table->dropForeign(['seller_id']);
        //        });
        Schema::dropIfExists('orders');
    }
};
