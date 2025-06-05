<?php

use App\Models\Voucher;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $vouchers = [
            [
                'code' => '10offZfx749',
                'type_id' => 1,
                'percentage' => 10
            ],
            [
                'code' => '29offZsCWb',
                'type_id' => 2,
                'percentage' => 29
            ],
        ];

        foreach ($vouchers as $voucher) {
            Voucher::create($voucher);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
    }
};
