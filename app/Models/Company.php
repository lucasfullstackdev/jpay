<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;

    protected $table = 'companies';
    protected $fillable = [
        'owner_id',
        'document',
        'name',
        'street',
        'number',
        'neighborhood',
        'city',
        'state',
        'country',
        'postal_code',
        'complement'
    ];

    public function documentFormatted(): Attribute
    {
        return Attribute::make(
            get: fn () => preg_replace('/^(\d{2})(\d{3})(\d{3})(\d{4})(\d{2})$/', '$1.$2.$3/$4-$5', $this->document)
        );
    }

    public function address(): Attribute
    {
        return Attribute::make(
            get: fn () => "$this->street, $this->number, "  . (empty($this->complement) ? '' : "$this->complement, ") .  "$this->neighborhood, Cidade {$this->city}-{$this->state}, CEP: $this->postal_code",
        );
    }
}
