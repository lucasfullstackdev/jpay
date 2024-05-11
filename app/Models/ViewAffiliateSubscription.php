<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ViewAffiliateSubscription extends Model
{
    protected $table = 'vw_affiliate_subscriptions';

    protected $casts = [
        'affiliate' => 'array',
        'billings' => 'array',
    ];
}
