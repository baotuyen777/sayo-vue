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
        Schema::table('orders', function (Blueprint $table) {
            if (!Schema::hasColumn('orders', 'product_id')) {
                $table->unsignedBigInteger('product_id')->nullable();
            }
            if (!Schema::hasColumn('orders', 'price')) {
                $table->bigInteger('price')->default(0)->nullable();
            }

            if (Schema::hasColumn('orders', 'user_id')) {
                $table->renameColumn('user_id', 'author_id');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
//        if (Schema::hasColumn('orders', 'product_id')) {
//            Schema::table('orders', function (Blueprint $table) {
//                $table->dropForeign(['product_id']);
//                $table->dropColumn('product_id');
//            });
//        }
    }
};
