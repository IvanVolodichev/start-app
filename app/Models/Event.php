<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Event extends Model
{

    use HasFactory;

    protected $fillable = [
        'title',
        'max_participant',
        'current_participant',
        'date',
        'start_time',
        'end_time',
        'comment',
        'address',
        'latitude',
        'longitude',
        'status',
        'user_id',
        'sport_id',
        'cloud_folder',
    ];

    public function sport(){
        return $this->belongsTo(Sport::class);
    }

    public function author()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function reports(){
        return $this->hasMany(Report::class);
    }

    public function participants(){
        return $this->hasMany(Participant::class);
    }

    public function titleImage(){
        $array = Storage::disk('reg')->allFiles($this->cloud_folder);
        
        if (!empty($array)) {
            return Storage::disk('reg')->url($array[0]);
        }
        return asset('./default.png');
    }
    protected function casts(): array
    {
        return [
            'date' => 'datetime:Y-m-d',
            'start_time' => 'datetime:H:i',
            'end_time' => 'datetime:H:i',
        ];
    }

}
