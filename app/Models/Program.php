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
        'type_id',
    ];
    
    public function type()
    {
        return $this->belongsTo(Type::class);
    }
    
    public function categories()
    {
        return $this->belongsToMany(Category::class, 'programs_categories');
    }
    
    public function links()
    {
        return $this->hasMany(Link::class);
    }
    
    public function rates()
    {
        return $this->hasMany(Rate::class);
    }
    
    public function getAvgRate()
    {
        return $this->hasMany(Rate::class)->avg('rate');
    }
}
