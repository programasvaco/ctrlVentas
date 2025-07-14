@extends('layouts.app')

@section('content')
    <h1>Detalles del Corte #{{ $corte->id }}</h1>
    
    <div class="card mb-4">
        <div class="card-body">
            <h5 class="card-title">Resumen</h5>
            <p><strong>Fecha Inicio:</strong> {{ $corte->fecha_inicio }}</p>
            <p><strong>Fecha Fin:</strong> {{ $corte->fecha_fin }}</p>
            <p><strong>Total Entradas:</strong> ${{ number_format($corte->total_entradas, 2) }}</p>
            <p><strong>Total Salidas:</strong> ${{ number_format($corte->total_salidas, 2) }}</p>
            <p><strong>Saldo Final:</strong> ${{ number_format($corte->saldo_final, 2) }}</p>
            <p><strong>Notas:</strong> {{ $corte->notas }}</p>
        </div>
    </div>
    
    <h3>Movimientos incluidos</h3>
    <table class="table">
        <!-- Similar a la tabla de index pero para los movimientos del corte -->
    </table>
@endsection