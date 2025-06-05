<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DocumentSigner extends Model
{
    use HasFactory;

    protected $table = 'document_signers';
    protected $fillable = [
        'key',
        'request_signature_key',
        'document',
        'signer',
        'sign_as',
        'refusable',
        'created_at',
        'updated_at',
        'url',
    ];
}
