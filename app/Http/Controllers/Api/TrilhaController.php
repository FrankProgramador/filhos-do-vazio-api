<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Trilha;
use Illuminate\Http\JsonResponse;

class TrilhaController extends Controller
{
    public function index(): JsonResponse
    {
        // Só o nível 1 é relevante aqui — é a única habilidade que a tela de
        // criação de personagem precisa mostrar antes da trilha ser escolhida.
        $trilhas = Trilha::with(['abilities' => fn ($query) => $query->wherePivot('level', 1)])->get();

        return response()->json($trilhas);
    }
}
