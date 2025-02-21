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
        Schema::table('store_information', function (Blueprint $table) {
            // حذف المفتاح الأجنبي القديم والعمود المرتبط به
            $table->dropForeign(['user_id']);
            $table->dropColumn('user_id');

            // إضافة العمود الجديد وربطه بالمفتاح الأجنبي
            $table->foreignId('admin_id')
                ->constrained('admins')
                ->onUpdate('cascade')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('store_information', function (Blueprint $table) {
            // حذف المفتاح الأجنبي الجديد والعمود المرتبط به
            $table->dropForeign(['admin_id']);
            $table->dropColumn('admin_id');
        });
    }
};