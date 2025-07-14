<?php

namespace App\Http\Controllers;

use App\Models\Articulo;
use App\Models\Compra;
use App\Models\DetCompra;
use App\Models\Inventario;
use App\Models\Proveedor;
use App\Models\Kardex;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Cxp;

class CompraController extends Controller
{
    public function index()
    {
        $compras = Compra::with('proveedor')->orderBy('created_at', 'desc')->get();
        return view('compras.index', compact('compras'));
    }

    public function create()
    {
        $proveedores = Proveedor::where('estado', 'activo')->get();
        $articulos = Articulo::where('estado', 'activo')->get();
        return view('compras.create', compact('proveedores', 'articulos'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'proveedor_id' => 'required|exists:proveedores,id',
            'referencia' => 'nullable|string|max:50|unique:compras,referencia',
            'detalles' => 'required|array|min:1',
            'detalles.*.articulo_id' => 'required|exists:articulos,id',
            'detalles.*.variedad' => 'required|string|max:100',
            'detalles.*.cantidad' => 'required|numeric|min:0.01',
            'detalles.*.costo' => 'required|numeric|min:0.01',
        ]);

        // Generar referencia si no se proporcionó
        $referencia = $request->referencia ?? 'COMP-' . Str::upper(Str::random(8));

        // Calcular total
        $total = collect($request->detalles)->sum(function ($detalle) {
            return $detalle['cantidad'] * $detalle['costo'];
        });

        // Crear la compra
        $compra = Compra::create([
            'proveedor_id' => $request->proveedor_id,
            'referencia' => $referencia,
            'total' => $total,
            'estado' => 'pendiente'
        ]);

        // Crear detalles
        foreach ($request->detalles as $detalle) {
            DetCompra::create([
                'compra_id' => $compra->id,
                'articulo_id' => $detalle['articulo_id'],
                'variedad' => $detalle['variedad'],
                'cantidad' => $detalle['cantidad'],
                'costo' => $detalle['costo']
            ]);

            // Actualizar inventario y obtener el objeto de inventario
            $inventario = $this->actualizarInventario($detalle);
            // Registrar movimiento en Kardex
            Kardex::create([
                'inventario_id' => $inventario->id,
                'tipo' => 'entrada',
                'fecha' => now(),
                'doc_relacionado' => $compra->referencia,
                'cantidad' => $detalle['cantidad'],
                'costo' => $detalle['costo']
            ]);
        }
        // Crear registro en CxP
        $proveedor = Proveedor::find($request->proveedor_id);
        $fechaVencimiento = now()->addDays($proveedor->dias_plazo);

        $cxp = Cxp::create([
            'proveedor_id' => $request->proveedor_id,
            'compra_id' => $compra->id,
            'fecha_venc' => $fechaVencimiento,
            'importe' => $total,
            'saldo' => $total,
            'estado' => 'pendiente'
        ]);

        // Actualizar saldo del proveedor
        $proveedor->increment('saldo', $total);

        return redirect()->route('compras.index')->with('success', 'Compra registrada correctamente.');
    }

    public function show(Compra $compra)
    {
        $compra->load('proveedor', 'detalles.articulo');
        return view('compras.show', compact('compra'));
    }

    public function completar(Compra $compra)
    {
        $compra->update(['estado' => 'completada']);
        return back()->with('success', 'Compra marcada como completada.');
    }

    protected function actualizarInventario($detalle)
    {
        $inventario = Inventario::firstOrCreate(
            [
                'articulo_id' => $detalle['articulo_id'],
                'variedad' => $detalle['variedad']
            ],
            [
                'existencia' => 0,
                'preciolst' => 0,
                'preciomin' => 0,
                'costo' => 0,
                'estado' => 'activo'
            ]
        );

        $inventario->increment('existencia', $detalle['cantidad']);
        $inventario->update([
            'costo' => $detalle['costo'],
            'preciolst' => $detalle['costo'] * 1.3, // 30% de margen
            'preciomin' => $detalle['costo'] * 1.2  // 20% de margen mínimo
        ]);

         return $inventario;
    }
}