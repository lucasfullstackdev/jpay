<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AsaasEvent extends Model
{
    use HasFactory;

    protected $table = 'asaas_events';
    protected $fillable = [
        'event'
    ];
}
