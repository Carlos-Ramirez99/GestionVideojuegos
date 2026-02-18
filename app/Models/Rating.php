<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rating extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'game_id',
        'rating',
    ];

    /**
     * Relación con User
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relación polimórfica con el contenido
     */
    public function content()
    {
        return $this->morphTo();
    }

    public function game()
    {
        return $this->belongsTo(Game::class);
    }
}



