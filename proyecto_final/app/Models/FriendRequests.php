<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FriendRequests extends Model
{
    use HasFactory;

    public $incrementing = false;

    protected $fillable = ['user_id', 'friend_id',];
}
