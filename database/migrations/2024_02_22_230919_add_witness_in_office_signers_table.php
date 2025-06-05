<?php

use App\Enums\SignerAs;
use App\Enums\SignerAuth;
use App\Models\OfficeSigner;
use App\Models\Signer;
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
            $table->string('document')->nullable()->after('name');
            $table->string('signer_id')->nullable()->change();
        });

        $witnesses = [
            [
                'name' => 'Testamento X',
                'document' => '00000000000',
                'sign_as' => SignerAs::WITNESS->value,
                'auth' => SignerAuth::API->value
            ],
            [
                'name' => 'Testamento Y',
                'document' => '00000000000',
                'sign_as' => SignerAs::WITNESS->value,
                'auth' => SignerAuth::API->value
            ],
            [
                'name' => 'Testamento Z',
                'document' => '00000000000',
                'sign_as' => SignerAs::PARTY->value,
                'auth' => SignerAuth::API->value
            ],
        ];

        foreach ($witnesses as $witness) {
            OfficeSigner::create($witness);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('office_signers', function (Blueprint $table) {
            $table->dropColumn('document');
        });
    }
};
