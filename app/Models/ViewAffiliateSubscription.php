<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ViewAffiliateSubscription extends Model
{
    protected $table = 'vw_affiliate_subscriptions';

    protected $primaryKey = 'affiliate_email';
    protected $keyType = 'string';
    public $incrementing = false;

    protected $casts = [
        'affiliate' => 'object',
        'billings' => 'object',
    ];
}
