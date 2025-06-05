<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Voucher extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'vouchers';

    protected $fillable = [
        'code',
        'type_id',
        'percentage',
        'affiliate_percentage'
    ];

    public function type()
    {
        return $this->belongsTo(VoucherType::class, 'type_id');
    }
}
