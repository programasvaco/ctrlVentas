<?php

namespace App\Http\Controllers;

use App\Models\Cxc;
use Illuminate\Http\Request;

class CxcController extends Controller
{
    public function __invoke(Request $request)
    {
        $cxc = Cxc::with(['cliente', 'venta'])
            ->orderBy('fecha_vencimiento')
            ->get();
            
        // Agrupar por cliente para el resumen
        $resumenClientes = $cxc->groupBy('cliente_id')->map(function ($cuentas) {
            return [
                'cliente' => $cuentas->first()->cliente,
                'total_saldo' => $cuentas->sum('saldo'),
                'cuentas' => $cuentas
            ];
        })->sortByDesc('total_saldo');

        return view('cxc.index', compact('cxc', 'resumenClientes'));
    }
}