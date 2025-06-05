<?php

namespace App\Models;

use Carbon\Carbon;
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

    public function wasMadeInLessThanAYear(): bool
    {
        return $this->where('customer', $this->customer)
            ->where('created_at', '>=', Carbon::now()->subYear())
            ->exists();
    }
}
