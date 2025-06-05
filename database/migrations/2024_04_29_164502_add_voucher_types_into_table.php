<?php

use App\Enums\Payment\VoucherType;
use App\Models\VoucherType as ModelsVoucherType;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        foreach (VoucherType::getValues() as $voucherType) {
            ModelsVoucherType::create([
                'name' => $voucherType->value,
            ]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
