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
        Schema::table('users', function (Blueprint $table) {
            // حذف الفريد الحالي
            $table->dropUnique(['email']);

            // إضافة الفريد المركب
            $table->unique(['email', 'admin_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // إعادة الفريد السابق
            $table->dropUnique(['email', 'admin_id']);
            $table->string('email')->unique()->nullable()->change();
        });
    }
};