@extends('layouts.app')

@section('title', 'Cuentas por Cobrar')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Cuentas por Cobrar</h1>
    </div>

    <div class="card mb-4">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">Resumen por Cliente</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>Cliente</th>
                            <th>Saldo Total</th>
                            <th>Cuentas Pendientes</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($resumenClientes as $resumen)
                        <tr>
                            <td>{{ $resumen['cliente']->nombre }}</td>
                            <td class="text-end">${{ number_format($resumen['total_saldo'], 2) }}</td>
                            <td class="text-center">{{ $resumen['cuentas']->count() }}</td>
                            <td>
                                <a href="#" class="btn btn-sm btn-info" 
                                   data-bs-toggle="collapse" 
                                   data-bs-target="#detalleCliente{{ $resumen['cliente']->id }}">
                                    <i class="bi bi-eye"></i> Ver Detalle
                                </a>
                            </td>
                        </tr>
                        <tr class="collapse" id="detalleCliente{{ $resumen['cliente']->id }}">
                            <td colspan="4">
                                <div class="table-responsive">
                                    <table class="table table-sm">
                                        <thead>
                                            <tr>
                                                <th>Venta</th>
                                                <th>Fecha Venc.</th>
                                                <th>Importe</th>
                                                <th>Saldo</th>
                                                <th>Estado</th>
                                                <th>Pago</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($resumen['cuentas'] as $cuenta)
                                            <tr>
                                                <td>{{ $cuenta->venta->folio }}</td>
                                                <td>{{ $cuenta->fecha_vencimiento->format('d/m/Y') }}</td>
                                                <td class="text-end">${{ number_format($cuenta->importe, 2) }}</td>
                                                <td class="text-end">${{ number_format($cuenta->saldo, 2) }}</td>
                                                <td>
                                                    <span class="badge bg-{{ 
                                                        $cuenta->estado == 'pagada' ? 'success' : 
                                                        ($cuenta->estado == 'parcial' ? 'warning' : 'danger') 
                                                    }}">
                                                        {{ ucfirst($cuenta->estado) }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <a href="{{ route('cxc.pagos.create', $cuenta) }}" class="btn btn-sm btn-success">
                                                        <i class="bi bi-cash"></i> Registrar Pago
                                                    </a>
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">Todas las Cuentas por Cobrar</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>Cliente</th>
                            <th>Venta</th>
                            <th>Fecha Venc.</th>
                            <th>Importe</th>
                            <th>Saldo</th>
                            <th>Estado</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($cxc as $cuenta)
                        <tr>
                            <td>{{ $cuenta->cliente->nombre }}</td>
                            <td>{{ $cuenta->venta->folio }}</td>
                            <td>{{ $cuenta->fecha_vencimiento->format('d/m/Y') }}</td>
                            <td class="text-end">${{ number_format($cuenta->importe, 2) }}</td>
                            <td class="text-end">${{ number_format($cuenta->saldo, 2) }}</td>
                            <td>
                                <span class="badge bg-{{ 
                                    $cuenta->estado == 'pagada' ? 'success' : 
                                    ($cuenta->estado == 'parcial' ? 'warning' : 'danger') 
                                }}">
                                    {{ ucfirst($cuenta->estado) }}
                                </span>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="card mt-4">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">Movimientos de Cuentas por Cobrar</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>Cliente</th>
                            <th>Venta</th>
                            <th>Fecha Movimiento</th>
                            <th>Tipo</th>
                            <th>Importe</th>
                            <th>Observaciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($cxc as $cuenta)
                            @foreach($cuenta->movimientos as $movimiento)
                            <tr>
                                <td>{{ $cuenta->cliente->nombre }}</td>
                                <td>{{ $cuenta->venta->folio }}</td>
                                <td>{{ $movimiento->fecha_pago->format('d/m/Y') }}</td>
                                <td>
                                    <span class="badge bg-{{ $movimiento->tipo == 'abono' ? 'success' : 'danger' }}">
                                        {{ ucfirst($movimiento->tipo) }}
                                    </span>
                                </td>
                                <td class="text-end">${{ number_format($movimiento->importe, 2) }}</td>
                                <td>{{ $movimiento->observaciones ?? 'N/A' }}</td>
                            </tr>
                            @endforeach
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
