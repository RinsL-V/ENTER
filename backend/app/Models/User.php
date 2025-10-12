<?php
// app/Models/User.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens; // Добавляем этот трейт

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable; // Добавляем HasApiTokens

    protected $fillable = [
        'name',
        'email',
        'password',
        'role'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    protected $attributes = [
        'role' => 'user'
    ];

    // Проверка, является ли пользователь админом
    public function isAdmin()
    {
        return $this->role === 'admin';
    }
}
