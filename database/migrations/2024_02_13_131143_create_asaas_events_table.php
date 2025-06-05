<?php

use App\Models\AsaasEvent;
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
        Schema::create('asaas_events', function (Blueprint $table) {
            $table->id();

            $table->string('event')->unique();

            $table->timestamps();
            $table->softDeletes();
        });

        $events = [
            ['event' => 'PAYMENT_CREATED'],
            ['event' => 'PAYMENT_AWAITING_RISK_ANALYSIS'],
            ['event' => 'PAYMENT_APPROVED_BY_RISK_ANALYSIS'],
            ['event' => 'PAYMENT_REPROVED_BY_RISK_ANALYSIS'],
            ['event' => 'PAYMENT_AUTHORIZED'],
            ['event' => 'PAYMENT_UPDATED'],
            ['event' => 'PAYMENT_CONFIRMED'],
            ['event' => 'PAYMENT_RECEIVED'],
            ['event' => 'PAYMENT_CREDIT_CARD_CAPTURE_REFUSED'],
            ['event' => 'PAYMENT_ANTICIPATED'],
            ['event' => 'PAYMENT_OVERDUE'],
            ['event' => 'PAYMENT_DELETED'],
            ['event' => 'PAYMENT_RESTORED'],
            ['event' => 'PAYMENT_REFUNDED'],
            ['event' => 'PAYMENT_REFUND_IN_PROGRESS'],
            ['event' => 'PAYMENT_RECEIVED_IN_CASH_UNDONE'],
            ['event' => 'PAYMENT_CHARGEBACK_REQUESTED'],
            ['event' => 'PAYMENT_CHARGEBACK_DISPUTE'],
            ['event' => 'PAYMENT_AWAITING_CHARGEBACK_REVERSAL'],
            ['event' => 'PAYMENT_DUNNING_RECEIVED'],
            ['event' => 'PAYMENT_DUNNING_REQUESTED'],
            ['event' => 'PAYMENT_BANK_SLIP_VIEWED'],
            ['event' => 'PAYMENT_CHECKOUT_VIEWED'],
        ];

        foreach ($events as $event) {
            AsaasEvent::create($event);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('asaas_events');
    }
};
