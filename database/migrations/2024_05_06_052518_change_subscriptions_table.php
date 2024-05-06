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
        Schema::table('subscriptions', function (Blueprint $table) {
            $table->string('voucher_code')->nullable()->after('voucher');
            $table->string('affiliate_code')->nullable()->after('voucher_code');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('subscriptions', function (Blueprint $table) {
            $table->dropForeign(['voucher_code']);
            $table->dropColumn('voucher_code');

            $table->dropColumn('affiliate_code');
        });
    }
};
