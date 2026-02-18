<?php

namespace App\Http\Controllers;

use App\Models\Game;
use App\Models\Rating;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;

class RatingController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'rating'  => 'required|integer|min:1|max:5',
            'game_id' => 'required|integer|exists:games,id',
        ]);

        $userId = auth()->id();

        // Detectar si ya existe
        $existing = Rating::where('user_id', $userId)
            ->where('game_id', $request->game_id)
            ->first();

        try {
            if ($existing) {
                //Permitir actualizar propia valoración
                $existing->update([
                    'rating' => $request->rating,
                ]);

                $message = 'Tu valoración se ha actualizado correctamente.';
                $ratingModel = $existing;
            } else {
                // Crear nueva
                $ratingModel = Rating::create([
                    'user_id' => $userId,
                    'game_id' => $request->game_id,
                    'rating'  => $request->rating,
                ]);

                $message = 'Valoración guardada correctamente.';
            }

            // Recalcular promedio
            $game = Game::find($request->game_id);
            $game?->updateAverageRating();

            $average = $game?->average_rating ?? 0;

            //NUEVO: total de valoraciones del juego
            $count = Rating::where('game_id', $request->game_id)->count();

            //Respuesta JSON o redirección
            if ($request->wantsJson()) {
                return response()->json([
                    'message' => $message,
                    'average' => round((float) $average, 2),
                    'rating'  => $ratingModel->rating,
                    'count'   => $count,              // ✅ añadido
                    'updated' => (bool) $existing,
                ]);
            }

            return back()->with('success', $message);

        } catch (QueryException $e) {
            // Manejar duplicados (por carrera / doble click, etc.)
            // MySQL: 1062, Postgres: 23505, SQLite: 19
            $sqlStateOrCode = $e->errorInfo[0] ?? null; // SQLSTATE
            $driverCode     = $e->errorInfo[1] ?? null; // code numérico (MySQL)

            $isDuplicate = ($sqlStateOrCode === '23000') || ($driverCode === 1062);

            if ($isDuplicate) {
                $msg = 'Ya habías valorado este juego. Se ha evitado un duplicado. Recarga e inténtalo de nuevo.';
                if ($request->wantsJson()) {
                    return response()->json(['message' => $msg], 409);
                }
                return back()->with('warning', $msg);
            }

            // Otro error de BD
            $msg = 'Error de base de datos al guardar la valoración.';
            if ($request->wantsJson()) {
                return response()->json(['message' => $msg], 500);
            }
            return back()->with('error', $msg);
        }
    }
}
