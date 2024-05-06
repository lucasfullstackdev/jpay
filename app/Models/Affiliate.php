<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Affiliate extends Model
{
    use HasFactory;

    protected $table = 'affiliates';
    protected $fillable = [
        'slug',
        'name',
        'email',
        'phone',
        'pix',
        'active'
    ];

    public function vouchers()
    {
        return $this->hasMany(AffiliateVoucher::class);
    }
}
