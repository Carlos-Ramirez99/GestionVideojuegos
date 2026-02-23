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

        //Detectar si ya existe
        $existing = Rating::where('user_id', $userId)
            ->where('game_id', $request->game_id)
            ->first();

        try {
            if ($existing) {
                //Permitir actualizar tu valoración
                $existing->update([
                    'rating' => $request->rating,
                ]);

                $message = 'Tu valoración se ha actualizado correctamente.';
                $ratingModel = $existing;
            } else {
                //Crear nueva
                $ratingModel = Rating::create([
                    'user_id' => $userId,
                    'game_id' => $request->game_id,
                    'rating'  => $request->rating,
                ]);

                $message = 'Valoración guardada correctamente.';
            }

            //Recalcular promedio
            $game = Game::find($request->game_id);
            $game?->updateAverageRating();

            $average = $game?->average_rating ?? 0;

            $count = Rating::where('game_id', $request->game_id)->count();

            //Respuesta JSON o redirección
            if ($request->wantsJson()) {
                return response()->json([
                    'message' => $message,
                    'average' => round((float) $average, 2),
                    'rating'  => $ratingModel->rating,
                    'count'   => $count,
                    'updated' => (bool) $existing,
                ]);
            }

            return back()->with('success', $message);

        } catch (QueryException $e) {
            // Manejar duplicados.
            $sqlStateOrCode = $e->errorInfo[0] ?? null;
            $driverCode     = $e->errorInfo[1] ?? null;

            $isDuplicate = ($sqlStateOrCode === '23000') || ($driverCode === 1062);

            if ($isDuplicate) {
                $msg = 'Ya habías valorado este juego. Se ha evitado un duplicado. Recarga e inténtalo de nuevo.';
                if ($request->wantsJson()) {
                    return response()->json(['message' => $msg], 409);
                }
                return back()->with('warning', $msg);
            }


            $msg = 'Error de base de datos al guardar la valoración.';
            if ($request->wantsJson()) {
                return response()->json(['message' => $msg], 500);
            }
            return back()->with('error', $msg);
        }
    }
}
