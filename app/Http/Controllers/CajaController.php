<?php

namespace App\Http\Controllers;

use App\Models\Caja;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CajaController extends Controller
{
    public function __invoke(Request $request)
    {
        $movimientos = Caja::whereNull('corte_id')
            ->orderBy('fecha', 'desc')
            ->orderBy('created_at', 'desc')
            ->paginate(25);

        $totalEntradas = Caja::where('tipo', 'entrada')->whereNull('corte_id')->sum('cantidad');
        $totalSalidas = Caja::where('tipo', 'salida')->whereNull('corte_id')->sum('cantidad');
        $saldo = $totalEntradas - $totalSalidas;

        return view('caja.index', compact('movimientos', 'totalEntradas', 'totalSalidas', 'saldo'));
    }
    public function createSalida()
    {
        return view('caja.salidas.create');
    }

    public function storeSalida(Request $request)
    {
        $request->validate([
            'fecha' => 'required|date',
            'concepto' => 'required|string|max:255',
            'cantidad' => 'required|numeric|min:0.01',
            'tipo_salida' => 'required|in:gasto,retiro'
        ]);

        $docRelacionado = strtoupper(substr($request->tipo_salida, 0, 3)) . '-' . date('Ymd') . '-' . Str::random(4);

        Caja::create([
            'tipo' => 'salida',
            'doc_relacionado' => $docRelacionado,
            'fecha' => $request->fecha,
            'cantidad' => $request->cantidad,
            'concepto' => ucfirst($request->tipo_salida) . ': ' . $request->concepto
        ]);

        return redirect()->route('caja.index')
            ->with('success', 'Salida de caja registrada correctamente');
    }
}