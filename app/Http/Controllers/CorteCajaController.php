<?php

namespace App\Http\Controllers;

use App\Services\CorteCajaService;
use Illuminate\Http\Request;
use App\Models\CorteCaja;

class CorteCajaController extends Controller
{
    protected $corteService;

    public function __construct(CorteCajaService $corteService)
    {
        $this->corteService = $corteService;
    }

    public function index()
    {
        $movimientosSinCorte = $this->corteService->obtenerMovimientosSinCorte();
        $corteCaja = CorteCaja::all();
        
        return view('cortes.index', compact('movimientosSinCorte', 'corteCaja'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'notas' => 'nullable|string|max:500'
        ]);

        $resultado = $this->corteService->crearCorte($request->all());

        if (!$resultado['success']) {
            $errorMessage = $resultado['error'] ?? 'Error desconocido al crear el corte';
            return redirect()->back()
                ->withInput()
                ->with('error', $errorMessage);
        }

        // Registro exitoso
        return redirect()->route('cortes.show', $resultado['corte']->id)
            ->with('success', $resultado['message'])
            ->with('movimientos', $resultado['movimientos']);
    }

    public function show($id)
    {
        $corte = CorteCaja::with('movimientos')->findOrFail($id);
        
        return view('cortes.show', compact('corte'));
    }
}