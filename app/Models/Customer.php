<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    protected $table = 'customers';
    protected $fillable = [
        'name',
        'email',
        'phone',
        'document',
        'sku',
        'street',
        'number',
        'neighborhood',
        'city',
        'state',
        'country',
        'postal_code'
    ];

    public function company()
    {
        return $this->hasOne(Company::class, 'owner_id', 'id');
    }

}
