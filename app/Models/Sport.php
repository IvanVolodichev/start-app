<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Sport extends Model
{
    use HasFactory;
    
    protected $fillable = ['name'];
    
    public function events()
    {
        return $this->hasMany(Event::class);
    }
}
