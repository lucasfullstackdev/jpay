<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Witness extends Model
{
    use HasFactory;

    protected $table = 'witness_document';
    protected $fillable = [
        'name',
        'document'
    ];

    public function documentFormatted(): Attribute
    {
        return Attribute::make(
            get: fn () => preg_replace('/^(\d{3})(\d{3})(\d{3})(\d{2})$/', '$1.$2.$3-$4', $this->document)
        );
    }
}
