<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Subscription extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'subscriptions';
    protected $fillable = [
        'sku',
        'customer',
        'value',
        'value_without_discount',
        'voucher',
        'voucher_code',
        'affiliate_code',
        'cycle',
        'billing_type',
        'description',
        'subscription'
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer', 'sku');
    }

    public function voucherModel()
    {
        return $this->belongsTo(Voucher::class, 'voucher_code', 'code');
    }

    public function affiliateModel()
    {
        return $this->belongsTo(Affiliate::class, 'affiliate_code', 'slug');
    }
}
