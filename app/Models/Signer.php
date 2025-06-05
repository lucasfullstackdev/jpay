<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Signer extends Model
{
    use HasFactory;

    protected $table = 'signers';
    protected $fillable = [
        'customer',
        'signer_id',
        'auth',
        'signer'
    ];
}
