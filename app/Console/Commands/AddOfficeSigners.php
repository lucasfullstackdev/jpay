<?php

namespace App\Console\Commands;

use App\Models\OfficeSigner;
use Illuminate\Console\Command;

class AddOfficeSigners extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'add-office-signers {name} {signer_id} {auth} {sign_as}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Adicionar signatários da API ao banco de dados.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        OfficeSigner::create([
            'name' => $this->argument('name'),
            'signer_id' => $this->argument('signer_id'),
            'auth' => $this->argument('auth'),
            'sign_as' => $this->argument('sign_as'),
        ]);

        echo "Signatário adicionado com sucesso!\n";
        // 
    }
}
