<?php
// app/Services/CorteCajaService.php

namespace App\Services;

use App\Models\Caja;
use App\Models\CorteCaja;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Exception;

class CorteCajaService
{
    public function crearCorte(array $data = []): array
    {
        DB::beginTransaction();

        try {
            $movimientosSinCorte = Caja::whereNull('corte_id')->get();
        
            if ($movimientosSinCorte->isEmpty()) {
                throw new \Exception('No hay movimientos para crear un corte');
            }

            $entradas = $movimientosSinCorte->where('tipo', 'entrada')->sum('cantidad');
            $salidas = $movimientosSinCorte->where('tipo', 'salida')->sum('cantidad');
            $saldoFinal = $entradas - $salidas;

            $fechas = $movimientosSinCorte->pluck('fecha')->sort();
            
            $corte = CorteCaja::create([
                'fecha_inicio' => $fechas->first(),
                'fecha_fin' => $fechas->last(),
                'total_entradas' => $entradas,
                'total_salidas' => $salidas,
                'saldo_final' => $saldoFinal,
                'notas' => $data['notas'] ?? null,
            ]);

            Caja::whereNull('corte_id')->update(['corte_id' => $corte->id]);

            DB::commit();

            return [
                'success' => true,
                'corte' => $corte,
                'message' => 'Corte creado exitosamente',
                'movimientos' => $movimientosSinCorte->count()
            ];
        } catch (\Exception $e) {
        DB::rollBack();
        
        return [
            'success' => false,
            'error' => $e->getMessage(),
            'code' => $e->getCode()
        ];
    }

    }

    public function obtenerMovimientosSinCorte()
    {
        return Caja::whereNull('corte_id')
            ->orderBy('fecha')
            ->get();
    }

    public function obtenerResumenCorte(CorteCaja $corte): array
    {
        return [
            'entradas' => $corte->total_entradas,
            'salidas' => $corte->total_salidas,
            'saldo' => $corte->saldo_final,
            'movimientos' => $corte->movimientos->count(),
        ];
    }
}