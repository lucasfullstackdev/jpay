<?php

use App\Models\ClickSignEvent;
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
        Schema::create('clicksign_events', function (Blueprint $table) {
            $table->id();

            $table->string('event')->unique();

            $table->timestamps();
            $table->softDeletes();
        });

        $events = [
            ['event' => 'add_image'],
            ['event' => 'add_signer'],
            ['event' => 'attempts_by_whatsapp_exceeded'],
            ['event' => 'facematch_refused'],
            ['event' => 'auto_close'],
            ['event' => 'cancel'],
            ['event' => 'close'],
            ['event' => 'custom'],
            ['event' => 'deadline'],
            ['event' => 'refusal'],
            ['event' => 'remove_signer'],
            ['event' => 'sign'],
            ['event' => 'update_auto_close'],
            ['event' => 'update_deadline'],
            ['event' => 'upload'],
        ];

        foreach ($events as $event) {
            ClickSignEvent::create($event);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clicksign_events');
    }
};
