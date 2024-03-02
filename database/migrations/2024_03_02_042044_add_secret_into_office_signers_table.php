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
        Schema::table('office_signers', function (Blueprint $table) {
            $table->text('secret')->nullable()->after('sign_as');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('office_signers', function (Blueprint $table) {
            $table->dropColumn('secret');
        });
    }
};
