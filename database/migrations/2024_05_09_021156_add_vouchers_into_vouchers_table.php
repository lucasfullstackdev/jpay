<?php

use App\Models\Voucher;
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
        $vouchers = [
            [
                'code' => 'k9vo70zzn5n',
                'type_id' => 1,
                'percentage' => 15,
                'affiliate_percentage' => 30,
            ],
            [
                'code' => 'g1rt60r20ox',
                'type_id' => 1,
                'percentage' => 20,
                'affiliate_percentage' => 30,
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
        //
    }
};
