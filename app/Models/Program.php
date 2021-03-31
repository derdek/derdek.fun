<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Program extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'name',
        'category',
        'type',
    ];
    
    protected $hidden = [
        'created_at',
        'user_id',
    ];
    
}
