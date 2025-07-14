<?php

namespace App\Http\Controllers;

use App\Models\Cxp;
use App\Models\DetCxp;
use App\Models\Proveedor;
use Illuminate\Http\Request;

class CxpController extends Controller
{
    public function index()
    {
        $cxp = Cxp::with(['proveedor', 'compra', 'movimientos'])
            ->orderBy('fecha_venc')
            ->get();
            
        $resumenProveedores = $cxp->groupBy('proveedor_id')->map(function ($cuentas) {
            return [
                'proveedor' => $cuentas->first()->proveedor,
                'total_saldo' => $cuentas->sum('saldo'),
                'cuentas' => $cuentas
            ];
        })->sortByDesc('total_saldo');

        return view('cxp.index', compact('cxp', 'resumenProveedores'));
    }

    public function registrarPago(Request $request, Cxp $cuenta)
    {
        $request->validate([
            'monto' => 'required|numeric|min:0.01|max:' . $cuenta->saldo,
            'fecha_pago' => 'required|date',
            'observaciones' => 'nullable|string|max:255'
        ]);

        // Registrar el movimiento de abono
        DetCxp::create([
            'cxp_id' => $cuenta->id,
            'fecha_pago' => $request->fecha_pago,
            'importe' => $request->monto,
            'tipo' => 'abono',
            'observaciones' => $request->observaciones
        ]);

        // Actualizar la cuenta por pagar
        $cuenta->saldo -= $request->monto;
        $cuenta->estado = $cuenta->saldo > 0 ? 'parcial' : 'pagado';
        $cuenta->save();

        // Actualizar saldo del proveedor
        $cuenta->proveedor->decrement('saldo', $request->monto);

        return redirect()->route('cxp.index')
            ->with('success', 'Pago registrado correctamente');
    }

    public function registrarCargo(Request $request, Cxp $cuenta)
    {
        $request->validate([
            'monto' => 'required|numeric|min:0.01',
            'fecha_pago' => 'required|date',
            'observaciones' => 'required|string|max:255'
        ]);

        // Registrar el movimiento de cargo
        DetCxp::create([
            'cxp_id' => $cuenta->id,
            'fecha_pago' => $request->fecha_pago,
            'importe' => $request->monto,
            'tipo' => 'cargo',
            'observaciones' => $request->observaciones
        ]);

        // Actualizar la cuenta por pagar
        $cuenta->saldo += $request->monto;
        $cuenta->estado = 'pendiente';
        $cuenta->save();

        // Actualizar saldo del proveedor
        $cuenta->proveedor->increment('saldo', $request->monto);

        return redirect()->route('cxp.index')
            ->with('success', 'Cargo registrado correctamente');
    }
}