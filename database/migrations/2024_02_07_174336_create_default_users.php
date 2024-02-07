<?php

use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $users = [
            [
                'name' => 'Josué Leite',
                'email' => 'atendimento.petrolina@oshi.com.br',
                'password' => Hash::make('biscoito'),
            ],
            [
                'name' => 'Lucas Oliveira',
                'email' => 'contato@jellycode.com.br',
                'password' => Hash::make('biscoito'),
            ],
            [
                'name' => 'Eduardo',
                'email' => 'eduardo@jellycode.com.br',
                'password' => Hash::make('biscoito'),
            ],
            [
                'name' => 'Bruno',
                'email' => 'bruno@jellycode.com.br',
                'password' => Hash::make('biscoito'),
            ],
        ];

        foreach ($users as $user) {
            User::create($user);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
    }
};
