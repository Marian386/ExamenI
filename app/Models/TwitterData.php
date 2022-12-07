<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TwitterData extends Model
{
    use HasFactory;


    protected $fillable = [
    
        'user_access_token' ,
        'twitter_oauth_token_secret',
        'user_id'
    ];
    
}
