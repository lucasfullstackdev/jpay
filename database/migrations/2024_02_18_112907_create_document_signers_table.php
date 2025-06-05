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
        Schema::create('document_signers', function (Blueprint $table) {
            $table->id();

            $table->string('key')->unique();
            $table->string('request_signature_key')->unique();
            $table->string('document');
            $table->string('signer');
            $table->string('sign_as');
            $table->boolean('refusable');
            $table->timestamp('created_at');
            $table->timestamp('updated_at');
            $table->string('url');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('document_signers');
    }
};
