<?php

namespace App\Models\CMS;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class CMSUser extends CMSModel
{
    use HasFactory;

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
