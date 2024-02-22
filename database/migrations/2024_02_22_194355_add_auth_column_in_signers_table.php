<?php

use App\Enums\SignerAuth;
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
        Schema::table('signers', function (Blueprint $table) {
            $table->string('auth')->nullable()->default(SignerAuth::EMAIL->value)->after('signer_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('signers', function (Blueprint $table) {
            $table->dropColumn('auth');
        });
    }
};
