<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class RunTestsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'run:tests';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Executa os comandos clear, cache:clear e test.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->call('clear');
        $this->call('cache:clear');
        $this->call('test');
    }
}
