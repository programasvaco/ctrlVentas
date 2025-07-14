<?php

namespace App\Http\Controllers;

use App\Models\Inventario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class InventarioController extends Controller
{
    public function index()
    {
        $inventarios = Inventario::with('articulo')->get();
        return view('inventarios.index', compact('inventarios'));
    }
    
    public function actPrecios(Request $request, Inventario $inventario) 
    {
        // Validación
        $request->validate([
            'preciolst' => 'required|numeric',
            'preciomin' => 'required|numeric'
        ]);

        // Actualización
        $inventario->update([
            'preciolst' => $request->preciolst,
            'preciomin' => $request->preciomin
        ]);

        // Redirección (302 es normal aquí)
        return redirect()->route('inventarios.index')->with('success', 'Precios actualizados correctamente');
    }
    public function __invoke(Request $request)
    {
        //
    }
}
