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
                'name' => 'Pessoa X',
                'email' => 'pessoa@x.com',
                'password' => Hash::make('biscoito'),
            ],
            [
                'name' => 'Pessoa Y',
                'email' => 'pessoa@y.com',
                'password' => Hash::make('biscoito'),
            ],
            [
                'name' => 'Pessoa Z',
                'email' => 'pessoa@z.com',
                'password' => Hash::make('biscoito'),
            ],
            [
                'name' => 'Pessoa W',
                'email' => 'pessoa@w.com',
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
