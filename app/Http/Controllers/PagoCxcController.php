<?php

namespace App\Http\Controllers;

use App\Models\Cxc;
use App\Models\DetCxc;
use App\Models\Cliente;
use App\Models\Caja;
use Illuminate\Http\Request;

class PagoCxcController extends Controller
{
    public function create(Cxc $cxc)
    {
        return view('cxc.pagos.create', compact('cxc'));
    }

    public function store(Request $request, Cxc $cxc)
    {
        $request->validate([
            'fecha_pago' => 'required|date',
            'importe' => 'required|numeric|min:0.01|max:' . $cxc->saldo,
            'observaciones' => 'nullable|string|max:255'
        ]);

        // Registrar el abono en det_cxc
        $pago = DetCxc::create([
            'cxc_id' => $cxc->id,
            'fecha_pago' => $request->fecha_pago,
            'importe' => $request->importe,
            'tipo' => 'abono',
            'observaciones' => $request->observaciones
        ]);

        // Actualizar la cuenta por cobrar
        $cxc->saldo -= $request->importe;
        $cxc->estado = $cxc->saldo > 0 ? 'parcial' : 'pagada';
        $cxc->save();

        // Actualizar saldo del cliente
        $cxc->cliente->decrement('saldo', $request->importe);

        // Registrar el ingreso en caja
        Caja::create([
            'tipo' => 'entrada',
            'doc_relacionado' => 'PAGO-' . $cxc->venta->folio,
            'fecha' => $request->fecha_pago,
            'cantidad' => $request->importe,
            'concepto' => 'Pago de cuenta por cobrar ' . $cxc->venta->folio
        ]);

        return redirect()->route('cxc.index')
            ->with('success', 'Pago registrado correctamente.');
    }
}