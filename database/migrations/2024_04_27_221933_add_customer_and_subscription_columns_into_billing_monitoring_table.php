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
        Schema::table('billing_monitoring', function (Blueprint $table) {
            $table->string('customer_id')->after('payment_id');
            $table->string('subscription_id')->nullable()->after('customer_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('billing_monitoring', function (Blueprint $table) {
            $table->dropColumn('customer_id');
            $table->dropColumn('subscription_id');
        });
    }
};
