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
        Schema::table('customers', function (Blueprint $table) {
            $table->string('street')->after('sku');
            $table->string('number')->after('street');
            $table->string('neighborhood')->after('number');
            $table->string('city')->after('neighborhood');
            $table->string('state')->after('city');
            $table->string('country')->after('state');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('customers', function (Blueprint $table) {
            $table->dropColumn(
                'street',
                'number',
                'neighborhood',
                'city',
                'state',
                'country'
            );
        });
    }
};
