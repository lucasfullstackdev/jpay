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
        Schema::create('affiliate_vouchers', function (Blueprint $table) {
            $table->id();

            $table->foreignId('affiliate_id')->constrained('affiliates');
            $table->string('voucher');
            $table->foreign('voucher')->references('code')->on('vouchers');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('affiliate_vouchers');
    }
};
