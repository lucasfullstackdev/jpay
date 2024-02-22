<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OfficeSigner extends Model
{
    use HasFactory;

    protected $table = 'office_signers';

    protected $fillable = [
        'name',
        'signer_id',
        'auth',
        'sign_as',
    ];
}
