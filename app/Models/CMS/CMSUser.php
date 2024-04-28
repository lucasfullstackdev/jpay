<?php

namespace App\Models\CMS;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CMSUser extends Model
{
    use HasFactory;

    protected $connection = 'correspondence_management_system';
    public $timestamps = false;

    protected $table = 'users';
    protected $fillable = [
        'display_name',
        'user_activation_key',
        'user_email',
        'user_login',
        'user_nicename',
        'user_pass',
        'user_registered',
        'user_status',
        'user_url',
    ];
}
