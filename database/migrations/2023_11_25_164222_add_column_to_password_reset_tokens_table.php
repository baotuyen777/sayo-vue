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
        if (!Schema::hasColumns('password_reset_tokens', ['updated_at', 'phone'])) {
            Schema::table('password_reset_tokens', function (Blueprint $table) {
                $table->timestamp('updated_at')->nullable();
                $table->string('phone')->after('email');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasColumns('password_reset_tokens', ['updated_at', 'phone'])) {
            Schema::table('password_reset_tokens', function (Blueprint $table) {
                $table->dropColumn('updated_at');
                $table->dropColumn('phone');
            });
        }
    }
};
