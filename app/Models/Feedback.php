<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Feedback extends Model
{
    use HasFactory;
    
    protected $table = 'feedbacks';

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    protected $fillable = [
        'message',
        'user_id',
        'status',
        'resolved_at',
    ];

    protected function casts(): array
    {
        return [
            'resolved_at' => 'datetime:Y-m-d H:i:s',
        ];
    }
}
