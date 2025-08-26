<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Carbon;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'verification_code',
        'verification_expires_at',
    ];

    protected $hidden = [
        'password',
        'remember_token',
        'verification_code',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'verification_expires_at' => 'datetime',
    ];

    public function isVerificationCodeValid(string $code): bool
    {
        return $this->verification_code === $code
            && $this->verification_expires_at !== null
            && $this->verification_expires_at->isFuture();
    }

    public function markEmailAsVerified(): void
    {
        $this->forceFill([
            'email_verified_at' => Carbon::now(),
            'verification_code' => null,
            'verification_expires_at' => null,
        ])->save();
    }
}
