@extends('layouts.app')

@section('title', 'Movimientos de Caja')

@section('content')
   <div class="d-flex justify-content-between align-items-center mb-4">
    <h1>Movimientos de Caja</h1>
        <div>
            <a href="{{ route('caja.salidas.create') }}" class="btn btn-danger me-2">
                <i class="bi bi-cash-stack"></i> Registrar Salida
            </a>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-body">
            <div class="row">
                <div class="col-md-4">
                    <div class="card bg-success text-white">
                        <div class="card-body">
                            <h5 class="card-title">Total Entradas</h5>
                            <p class="card-text h4">${{ number_format($totalEntradas, 2) }}</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card bg-danger text-white">
                        <div class="card-body">
                            <h5 class="card-title">Total Salidas</h5>
                            <p class="card-text h4">${{ number_format($totalSalidas, 2) }}</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card bg-primary text-white">
                        <div class="card-body">
                            <h5 class="card-title">Saldo Actual</h5>
                            <p class="card-text h4">${{ number_format($saldo, 2) }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead class="table-dark">
                        <tr>
                            <th>Fecha</th>
                            <th>Tipo</th>
                            <th>Documento</th>
                            <th>Concepto</th>
                            <th>Cantidad</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($movimientos as $movimiento)
                        <tr>
                            <td>{{ $movimiento->fecha->format('d/m/Y') }}</td>
                            <td>
                                <span class="badge bg-{{ $movimiento->tipo == 'entrada' ? 'success' : 'danger' }}">
                                    {{ ucfirst($movimiento->tipo) }}
                                </span>
                            </td>
                            <td>{{ $movimiento->doc_relacionado }}</td>
                            <td>{{ $movimiento->concepto ?? 'N/A' }}</td>
                            <td class="text-end">${{ number_format($movimiento->cantidad, 2) }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="mt-4">
                {{ $movimientos->links() }}
            </div>
        </div>
    </div>
@endsection