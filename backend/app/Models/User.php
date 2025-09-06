<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected $appends = ['token'];

    public function getTokenAttribute()
    {
        return $this->attributes['token'] ?? null;
    }

    public function setTokenAttribute($value)
    {
        $this->attributes['token'] = $value;
    }

    public function verificationCodes()
    {
        return $this->hasMany(VerificationCode::class);
    }

    public function latestVerificationCode()
    {
        return $this->hasOne(VerificationCode::class)->latest();
    }

    public function canRequestNewCode(): bool
    {
        $lastCode = $this->verificationCodes()->latest()->first();

        if (!$lastCode) {
            return true;
        }

        return $lastCode->created_at->addSeconds(60)->isPast();
    }

    public function isBlocked(): bool
    {
        $recentAttempts = $this->verificationCodes()
            ->where('created_at', '>=', now()->subMinutes(30))
            ->count();

        return $recentAttempts >= 5;
    }

    public function markEmailAsVerified(): void
    {
        $this->forceFill([
            'email_verified_at' => now(),
        ])->save();
    }
}
