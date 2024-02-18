<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Document extends Model
{
    use HasFactory;
    protected $table = 'documents';
    protected $fillable = [
        'customer',
        'document_id',
        'document',
    ];

    public function owner(): HasOne
    {
        return $this->hasOne(Customer::class, 'sku', 'customer');
    }
}
