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
        Voucher::where('code', '10offZfx749')->limit(1)->update(['affiliate_percentage' => 30]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
