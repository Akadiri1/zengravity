<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CourseMaterial extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'course_name',
        'file_path',
        'extracted_text',
        'is_indexed',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
