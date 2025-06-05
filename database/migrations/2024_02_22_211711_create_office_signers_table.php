<?php

use App\Enums\SignerAs;
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
        Schema::create('office_signers', function (Blueprint $table) {
            $table->id();

            $table->string('name');
            $table->string('signer_id')->unique();
            $table->string('auth');
            $table->string('sign_as');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('office_signers');
    }
};
