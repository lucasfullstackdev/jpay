<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DocumentMonitoring extends Model
{
    use HasFactory;
    protected $table = 'document_monitoring';
    protected $fillable = [
        'document',
        'event_name',
        'event',
    ];
}
