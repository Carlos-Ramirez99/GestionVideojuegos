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

    /**
     * Campos asignables en masa
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
    ];

    /**
     * Campos ocultos al serializar
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Casts
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    // ---------------------------------------
    // 2. Relación hasMany con contenido (Games)
    public function games()
    {
        return $this->hasMany(\App\Models\Game::class);
    }

    // 3. Relación hasMany con Ratings
    public function ratings()
    {
        return $this->hasMany(\App\Models\Rating::class);
    }

    // 4. Relación hasMany con Reviews (Comentarios)
    public function reviews()
    {
        return $this->hasMany(\App\Models\Review::class);
    }

    // ---------------------------------------
    // 5. Método helper isAdmin
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    // 6. Método helper isUser
    public function isUser(): bool
    {
        return $this->role === 'user';
    }
}
