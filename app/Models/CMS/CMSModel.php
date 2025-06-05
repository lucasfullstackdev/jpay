<?php

namespace App\Models\CMS;

use Illuminate\Database\Eloquent\Model;

abstract class CMSModel extends Model
{
  protected $connection = 'correspondence_management_system';
  public $timestamps = false;
}
