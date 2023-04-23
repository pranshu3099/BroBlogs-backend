<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Likes extends Model
{
    use HasFactory;
    protected $fillable = [
        'count',
        'post_id',
        'user_id',
        'category_id',
    ];
}
