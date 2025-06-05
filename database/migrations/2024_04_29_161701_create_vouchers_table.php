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
        Schema::create('vouchers', function (Blueprint $table) {
            $table->id();

            $table->string('code')->unique();
            $table->foreignId('type_id')->constrained('voucher_types');
            $table->integer('percentage');

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.ff
     */
    public function down(): void
    {
        Schema::dropIfExists('vouchers');
    }
};
