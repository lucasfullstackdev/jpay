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
                'name' => 'Lucas Santana de Oliveira',
                'document' => '06575305300',
                'sign_as' => SignerAs::WITNESS->value,
                'auth' => SignerAuth::API->value
            ],
            [
                'name' => 'Eduardo Batista Alves',
                'document' => '07889759517',
                'sign_as' => SignerAs::WITNESS->value,
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
