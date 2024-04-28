<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
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
        'person',
        'document',
        'sku',
        'street',
        'number',
        'neighborhood',
        'city',
        'state',
        'country',
        'postal_code',
        'complement'
    ];

    public function subscription()
    {
        return $this->hasOne(Subscription::class, 'customer', 'sku')->latest()->first();
    }

    public function company()
    {
        return $this->hasOne(Company::class, 'owner_id', 'id');
    }

    public function documentFormatted(): Attribute
    {
        return Attribute::make(
            get: fn () => preg_replace('/^(\d{3})(\d{3})(\d{3})(\d{2})$/', '$1.$2.$3-$4', $this->document)
        );
    }

    public function address(): Attribute
    {
        return Attribute::make(
            get: fn () => "$this->street, $this->number, "  . (empty($this->complement) ? '' : "$this->complement, ") .  "$this->neighborhood, Cidade {$this->city}-{$this->state}, CEP: $this->postal_code",
        );
    }
}
