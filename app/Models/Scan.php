<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Scan extends Model
{
    protected $fillable = [
        'user_id',
        'media_type',
        'file_path',
        'safety_score',
        'violations',
        'ai_feedback',
    ];

    protected $casts = [
        'violations' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
