<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    use HasFactory;

    protected $table = 'blogs';

    protected $fillable = [
        'title',
        'sub_content',
        'content',
        'date',
        'image', // <--- ADD THIS TO FILLABLE
        'is_active',
    ];
}
