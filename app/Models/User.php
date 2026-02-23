<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

/**
 * @property string  $role
 */

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];


    // Relación hasMany con contenido (Games)
    public function games()
    {
        return $this->hasMany(\App\Models\Game::class);
    }

    // Relación hasMany con Ratings
    public function ratings()
    {
        return $this->hasMany(\App\Models\Rating::class);
    }

    // Relación hasMany con Reviews (Comentarios)
    public function reviews()
    {
        return $this->hasMany(\App\Models\Review::class);
    }

    // ---------------------------------------
    // Método helper isAdmin
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    // Método helper isUser
    public function isUser(): bool
    {
        return $this->role === 'user';
    }
}
