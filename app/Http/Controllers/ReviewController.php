<?php

namespace App\Http\Controllers;

use App\Models\Game;
use App\Models\Review;
use App\Http\Requests\StoreReviewRequest;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    //crear comentario

    public function store(StoreReviewRequest $request, Game $game)
    {
        $data = $request->validated();

        Review::create([
            'user_id' => auth()->id(),
            'game_id' => $game->id,
            'title' => $data['title'] ?? null,
            'content' => $data['content'],
        ]);

        return back()->with('success', 'Reseña creada correctamente.');
    }


    //editar tu comentario
    public function update(Request $request, Review $review)
    {
        //creador o admin
        if (auth()->id() !== $review->user_id && auth()->user()->role !== 'admin') {
            abort(403);
        }

        $data = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
        ]);

        $review->update($data);

        return back()->with('success', 'Reseña actualizada correctamente.');
    }

    //eliminar
    public function destroy(Review $review)
    {
        //creador o admin
        if (auth()->id() !== $review->user_id && auth()->user()->role !== 'admin') {
            abort(403);
        }

        $review->delete();

        return back()->with('success', 'Reseña eliminada correctamente.');
    }
}
