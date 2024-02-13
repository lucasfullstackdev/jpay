<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BillingMonitoring extends Model
{
    use HasFactory;

    protected $table = 'billing_monitoring';
    protected $fillable = [
        'event',
        'payment_id',
        'payment'
    ];
}
