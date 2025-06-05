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
        Schema::create('billing_sending', function (Blueprint $table) {
            $table->id();

            $table->string('sku')->unique();                               //pay_3zneuksr86yev81i
            $table->string('customer')->references('id')->on('customers'); //cus_000005876798

            $table->decimal('value');
            $table->decimal('net_value');
            $table->decimal('billing_type');
            $table->date('due_date');

            $table->string('invoice_url')->unique();
            $table->string('invoice_number')->unique();

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('billing_sending');
    }
};
