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
        'cycle',
        'description',
        'subscription'
    ];
}
