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
        Schema::table('post_comment', function (Blueprint $table) {
            $table->integer('status')->after('parent_id')->default(STATUS_PENDING)->comment('1: pending, 2: approved, 3: reject');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('post_comment', function (Blueprint $table) {
            $table->dropColumn('status');
        });
    }
};
