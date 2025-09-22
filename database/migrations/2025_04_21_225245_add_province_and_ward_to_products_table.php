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
        Schema::table('products', function (Blueprint $table) {
            // Check if province_id doesn't exist before adding it
            if (!Schema::hasColumn('products', 'province_id')) {
                $table->unsignedBigInteger('province_id')->nullable()->after('author_id');
                $table->foreign('province_id')->references('id')->on('provinces')->onDelete('set null');
            }
            
            // Check if ward_id doesn't exist before adding it
            if (!Schema::hasColumn('products', 'ward_id')) {
                $table->unsignedBigInteger('ward_id')->nullable()->after('province_id');
                $table->foreign('ward_id')->references('id')->on('wards')->onDelete('set null');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            // Only drop columns if they were added by this migration
            // This is just a safeguard in case the columns existed previously
            if (Schema::hasColumn('products', 'province_id')) {
                $table->dropForeign(['province_id']);
                $table->dropColumn('province_id');
            }
            
            if (Schema::hasColumn('products', 'ward_id')) {
                $table->dropForeign(['ward_id']);
                $table->dropColumn('ward_id');
            }
        });
    }
};
