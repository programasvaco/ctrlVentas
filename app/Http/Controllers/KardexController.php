<?php

namespace App\Http\Controllers;

use App\Models\Inventario;
use App\Models\Kardex;
use Illuminate\Http\Request;

class KardexController extends Controller
{
    public function __invoke(Request $request, $inventarioId = null)
    {
        $query = Kardex::with('inventario.articulo')
            ->orderBy('fecha', 'desc')
            ->orderBy('created_at', 'desc');

        if ($inventarioId) {
            $query->where('inventario_id', $inventarioId);
            $inventario = Inventario::with('articulo')->findOrFail($inventarioId);
        }

        $kardex = $query->paginate(25);

        return view('kardex.index', [
            'kardex' => $kardex,
            'inventario' => $inventario ?? null
        ]);
    }
}