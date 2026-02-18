<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Game extends Model
{
    use HasFactory;
    //
    protected $fillable = [
        'user_id',
        'title',
        'developer',
        'distributor',
        'description',
        'game_mode',
        'cover_image',
        'classification',
        'genre',
        'platform',
        'release_year',
        'rating',
        'average_rating',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function ratings()
    {
        return $this->hasMany(Rating::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    //Actualiza el promedio de calificacion
    public function updateAverageRating()
    {
        $average = $this->ratings()->avg('rating');

        $this->average_rating = round((float) $average, 2);
        $this->save();
    }


}
