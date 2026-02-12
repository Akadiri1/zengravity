<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Collab extends Model
{
    protected $fillable = [
        'user_id',
        'niche',
        'bio_summary',
        'vibe_vector',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
