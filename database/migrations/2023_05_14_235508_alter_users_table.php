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
            $table->foreignId('departments_id')->nullable()->constrained('departments');
            $table->integer('status')->default(1);
            $table->integer('role')->default(3); // 1:admin, 2:staff, 3:customer
            $table->string('phone');
            $table->text('bio')->nullable();
            $table->string('cccd')->nullable();
            $table->date('birthday')->nullable();
            $table->tinyInteger('gender')->nullable();
            $table->integer('verified_level')->default(0);

            $table->unsignedBigInteger('avatar_id')->nullable();
            $table->foreign('avatar_id')->references('id')->on('files')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign('users_departments_id_foreign');
            $table->dropForeign('users_avatar_id_foreign');
//            $table->dropColumn('departments_id', 'status');
        });
    }
};
