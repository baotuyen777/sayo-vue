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
        Schema::table('users', function (Blueprint $table) {
//            $table->foreignId('departments_id')->nullable()->constrained('departments');
            $table->integer('departments_id')->nullable();
            $table->integer('status')->default(STATUS_PENDING)->comment('1: pending, 2: approved, 3: reject');
            $table->integer('role')->default(ROLE_CUSTOMER); // 1:admin, 2:staff, 3:customer
            $table->string('phone');
            $table->text('bio')->nullable();
            $table->string('cccd')->nullable();
            $table->date('birthday')->nullable();
            $table->tinyInteger('gender')->nullable();
//            $table->integer('verified_level')->default(0);

            $table->unsignedBigInteger('avatar_id')->nullable();
            $table->foreign('avatar_id')->references('id')->on('files');

            $table->unsignedBigInteger('province_id')->nullable();
            $table->foreign('province_id')->references('id')->on('provinces')->onDelete('cascade');

            $table->unsignedBigInteger('district_id')->nullable();
            $table->foreign('district_id')->references('id')->on('districts')->onDelete('cascade');

            $table->unsignedBigInteger('ward_id')->nullable();
            $table->foreign('ward_id')->references('id')->on('wards')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
//            $table->dropForeign('users_departments_id_foreign');
            $table->dropForeign('users_avatar_id_foreign');
            $table->dropForeign('users_province_id_foreign');
            $table->dropForeign('users_district_id_foreign');
            $table->dropForeign('users_ward_id_foreign');
//            $table->dropColumn('departments_id', 'status');
        });
    }
};
