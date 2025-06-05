<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClickSignEvent extends Model
{
    use HasFactory;
    protected $table = 'clicksign_events';
    protected $fillable = ['event'];
}
