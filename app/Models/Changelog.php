<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Changelog extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'body',
        'version',
        'published_at',
    ];

    protected $casts = [
        'published_at' => 'datetime',
    ];
}
