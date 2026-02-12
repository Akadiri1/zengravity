<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Hive extends Model
{
    protected $fillable = [
        'trend_name',
        'platform',
        'engagement_surge',
    ];
}
