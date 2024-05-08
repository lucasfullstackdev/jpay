<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AffiliateVoucher extends Model
{
    use HasFactory;

    protected $table = 'affiliate_vouchers';
    protected $fillable = [
        'affiliate_id',
        'voucher'
    ];

    public function affiliate()
    {
        return $this->belongsTo(Affiliate::class);
    }

    public function voucher()
    {
        return $this->belongsTo(Voucher::class);
    }
}
