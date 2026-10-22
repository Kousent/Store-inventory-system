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
        Schema::table('store_settings', function (Blueprint $table) {
            $table->string('currency_code', 3)->default('PEN');
        });

        Schema::table('orders', function (Blueprint $table) {
            $table->string('currency_code', 3)->default('PEN');
        });

        Schema::table('products', function (Blueprint $table) {
            $table->string('category', 120)->nullable()->after('description')->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropIndex(['category']);
            $table->dropColumn('category');
        });

        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn('currency_code');
        });

        Schema::table('store_settings', function (Blueprint $table) {
            $table->dropColumn('currency_code');
        });
    }
};
