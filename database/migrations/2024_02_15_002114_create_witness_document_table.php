<?php

use App\Models\Witness;
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
        $this->down();
        Schema::create('witness_document', function (Blueprint $table) {
            $table->id();

            $table->string('name');
            $table->string('document', 11)->unique();

            $table->timestamps();
            $table->softDeletes();
        });

        $witnesses = [
            ['name' => 'Lucas Santana de Oliveira', 'document' => '06575305300'],
            ['name' => 'Eduardo Batista Alves', 'document' => '07889759517'],
        ];

        foreach ($witnesses as $witness) {
            Witness::create($witness);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('witness_document');
    }
};
