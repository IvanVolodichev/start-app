<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'bio',
        'email',
        'password',
        'avatar',
        'provider',
        'provider_id'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function events()
    {
        return $this->hasMany(Event::class);
    }
    
    // Дополнительные методы
    public function getIsAdminAttribute()
    {
        return $this->role === 'admin';
    }
    
    public function hasJoinedEvent($eventId)
    {
        return $this->participations()->where('event_id', $eventId)->exists();
    }
    
    public function participations()
    {
        return $this->hasMany(Participant::class);
    }
    
    public function getAvatarUrlAttribute()
    {
        if (empty($this->avatar)) {
            return asset('images/default-avatar.png');
        }
        
        return $this->avatar;
    }
    
    public function ownsEvent($event)
    {
        if (is_numeric($event)) {
            return $this->events()->where('id', $event)->exists();
        }
        
        return $this->id === $event->user_id;
    }
}
