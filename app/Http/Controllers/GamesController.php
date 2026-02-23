<?php

namespace App\Http\Controllers;

use App\Models\Game;
use Illuminate\Http\Request;
use App\Http\Requests\StoreRequest;
use App\Http\Requests\UpdateRequest;
use Illuminate\Auth\Events\Validated;
use Illuminate\Container\Attributes\Auth;

class GamesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $games = Game::with('user')->paginate(15);
        return view('games.index', compact('games'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view('games.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $data = $request->validate([
            'title' => 'required|string|max:255',
            'developer' => 'required|string|max:255',
            'distributor' => 'required|string|max:255',
            'description' => 'required|string',
            'game_mode' => 'required|string|max:255',
            'classification' => 'required|string|max:255',
            'genre' => 'required|string|max:255',
            'platform' => 'required|string|max:255',
            'release_year' => 'required|integer|min:1950|max:' . (date('Y') + 1),
            'cover_image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        if ($request->hasFile('cover_image')) {
            $path = $request->file('cover_image')->store('covers', 'public');
            $data['cover_image'] = $path;
        } else {
            $data['cover_image'] = null; // 👈 importante
        }

        $data['user_id'] = auth()->id();
        $data['average_rating'] = 0;

        Game::create($data);

        return redirect()->route('games.index')->with('success', 'Juego creado correctamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Game $game)
    {
        $ratingsCount = $game->ratings()->count();

        $userRating = auth()->check()
            ? $game->ratings()
                ->where('user_id', auth()->id())
                ->value('rating')
            : null;

        //Obtener reseñas
        $reviews = $game->reviews()
            ->latest()
            ->get();

        return view('games.show', compact(
            'game',
            'ratingsCount',
            'userRating',
            'reviews'
        ));
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Game $game)
    {
        //
        return view('games.edit', compact('game'));

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRequest $request, Game $game)
    {
        //


        $game->update($request->validated());

        return redirect()->route('games.show', $game)->with('success', 'Videojuego actualizado correctamente');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Game $game)
    {
        //
        $game->delete();
        return redirect()->route('games.index')->with('success', 'Videojuego eliminado correctamente');
    }
}
