<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class userAchievement extends Model
{
    use HasFactory;
    protected $fillable = [
        'order',
        'user_id',
        'title',
        'description'
        
    ];
}

