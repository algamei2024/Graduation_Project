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
        Schema::table('store_information', function (Blueprint $table) {
            $table->string('address_store');
            $table->string('num_struct');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('store_information', function (Blueprint $table) {
            $table->dropColumn(['address_store', 'num_struct']);
        });
    }
};
