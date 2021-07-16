<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Program extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'name',
        'type',
    ];
    
    protected $hidden = [
        'created_at',
        'user_id',
    ];
    
    public function type()
    {
        return $this->belongsTo(Type::class);
    }
    
    public function categories()
    {
        return $this->belongsToMany(Category::class, 'programs_categories');
    }
}
