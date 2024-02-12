<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BillingSending extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'billing_sending';
    protected $fillable = [
        'sku',
        'customer',
        'value',
        'net_value',
        'billing_type',
        'due_date',
        'invoice_url',
        'invoice_number'
    ];
}
