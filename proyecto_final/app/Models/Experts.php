<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Experts extends Model
{
    use HasFactory;

    protected $table = 'experts';

    protected $fillable = [
        'user_id', 'nationality', 'dni', 'university', 'title'
    ];
}
