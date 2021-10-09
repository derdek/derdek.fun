<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'name',
    ];
    
    protected $hidden = [
        'created_at',
        'user_id',
    ];
    
    public function programs()
    {
        return $this->belongsToMany(Program::class, 'programs_categories');
    }
}
