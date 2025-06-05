<?php

namespace App\Jobs;

use App\Dtos\DiscordMessage;
use App\Services\Log\DiscordService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendErrorToDiscordJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private DiscordService $discordService;

    /**
     * Create a new job instance.
     */
    public function __construct(public DiscordMessage $discordMessage, private string $channel = '')
    {
        $this->discordService = new DiscordService($this->channel);
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $this->discordService->send($this->discordMessage);
    }
}
