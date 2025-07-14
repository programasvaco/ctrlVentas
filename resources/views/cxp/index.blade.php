@extends('layouts.app')

@section('title', 'Cuentas por Pagar')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Cuentas por Pagar</h1>
    </div>

    <div class="card mb-4">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">Resumen por Proveedor</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>Proveedor</th>
                            <th>Saldo Total</th>
                            <th>Cuentas Pendientes</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($resumenProveedores as $resumen)
                        <tr>
                            <td>{{ $resumen['proveedor']->nombre }}</td>
                            <td class="text-end">${{ number_format($resumen['total_saldo'], 2) }}</td>
                            <td class="text-center">{{ $resumen['cuentas']->count() }}</td>
                            <td>
                                <a href="#" class="btn btn-sm btn-info" 
                                   data-bs-toggle="collapse" 
                                   data-bs-target="#detalleProveedor{{ $resumen['proveedor']->id }}">
                                    <i class="bi bi-eye"></i> Ver Detalle
                                </a>
                            </td>
                        </tr>
                        <tr class="collapse" id="detalleProveedor{{ $resumen['proveedor']->id }}">
                            <td colspan="4">
                                <div class="table-responsive">
                                    <table class="table table-sm">
                                        <thead>
                                            <tr>
                                                <th>Compra</th>
                                                <th>Fecha Venc.</th>
                                                <th>Importe</th>
                                                <th>Saldo</th>
                                                <th>Estado</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($resumen['cuentas'] as $cuenta)
                                                <tr>
                                                    <td>{{ $cuenta->compra->referencia }}</td>
                                                    <td>{{ $cuenta->fecha_venc->format('d/m/Y') }}</td>
                                                    <td class="text-end">${{ number_format($cuenta->importe, 2) }}</td>
                                                    <td class="text-end">${{ number_format($cuenta->saldo, 2) }}</td>
                                                    <td>
                                                        <span class="badge bg-{{ 
                                                            $cuenta->estado == 'pagado' ? 'success' : 
                                                            ($cuenta->estado == 'parcial' ? 'warning' : 'danger') 
                                                        }}">
                                                            {{ ucfirst($cuenta->estado) }}
                                                        </span>
                                                    </td>
                                                    <td>
                                                        @if($cuenta->saldo > 0)
                                                        <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#pagoModal{{ $cuenta->id }}">
                                                            <i class="bi bi-cash"></i> Pagar
                                                        </button>
                                                        <button class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#cargoModal{{ $cuenta->id }}">
                                                            <i class="bi bi-plus-circle"></i> Cargo
                                                        </button>
                                                        <!-- Modal de pago -->
                                                        <div class="modal fade" id="pagoModal{{ $cuenta->id }}" tabindex="-1">
                                                            <div class="modal-dialog">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <h5 class="modal-title">Registrar Pago</h5>
                                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                                    </div>
                                                                    <form action="{{ route('cxp.pagar', $cuenta) }}" method="POST">
                                                                        @csrf
                                                                        <div class="modal-body">
                                                                            <div class="mb-3">
                                                                                <label class="form-label">Cuenta por Pagar</label>
                                                                                <input type="text" class="form-control" value="Compra {{ $cuenta->compra->referencia }} - {{ $cuenta->proveedor->nombre }}" readonly>
                                                                            </div>
                                                                            <div class="mb-3">
                                                                                <label class="form-label">Saldo Actual</label>
                                                                                <input type="text" class="form-control" value="${{ number_format($cuenta->saldo, 2) }}" readonly>
                                                                            </div>
                                                                            <div class="mb-3">
                                                                                <label class="form-label">Monto a Pagar *</label>
                                                                                <input type="number" step="0.01" class="form-control" name="monto" 
                                                                                    max="{{ $cuenta->saldo }}" required>
                                                                            </div>
                                                                            <div class="mb-3">
                                                                                <label class="form-label">Fecha de Pago *</label>
                                                                                <input type="date" class="form-control" name="fecha_pago" 
                                                                                    value="{{ now()->format('Y-m-d') }}" required>
                                                                            </div>
                                                                            <div class="mb-3">
                                                                                <label class="form-label">Observaciones</label>
                                                                                <textarea class="form-control" name="observaciones" rows="2"></textarea>
                                                                            </div>
                                                                        </div>
                                                                        <div class="modal-footer">
                                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                                                            <button type="submit" class="btn btn-primary">Registrar Pago</button>
                                                                        </div>
                                                                    </form>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        @endif
                                                    </td>
                                                </tr>
                                                <!-- Modal para cargos -->
                                                <div class="modal fade" id="cargoModal{{ $cuenta->id }}" tabindex="-1">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title">Registrar Cargo Adicional</h5>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                            </div>
                                                            <form action="{{ route('cxp.cargar', $cuenta) }}" method="POST">
                                                                @csrf
                                                                <div class="modal-body">
                                                                    <div class="mb-3">
                                                                        <label class="form-label">Cuenta por Pagar</label>
                                                                        <input type="text" class="form-control" 
                                                                            value="Compra {{ $cuenta->compra->referencia }} - {{ $cuenta->proveedor->nombre }}" readonly>
                                                                    </div>
                                                                    <div class="mb-3">
                                                                        <label class="form-label">Saldo Actual</label>
                                                                        <input type="text" class="form-control" 
                                                                            value="${{ number_format($cuenta->saldo, 2) }}" readonly>
                                                                    </div>
                                                                    <div class="mb-3">
                                                                        <label class="form-label">Monto del Cargo *</label>
                                                                        <input type="number" step="0.01" class="form-control" 
                                                                            name="monto" min="0.01" required>
                                                                    </div>
                                                                    <div class="mb-3">
                                                                        <label class="form-label">Fecha del Cargo *</label>
                                                                        <input type="date" class="form-control" name="fecha_pago" 
                                                                            value="{{ now()->format('Y-m-d') }}" required>
                                                                    </div>
                                                                    <div class="mb-3">
                                                                        <label class="form-label">Motivo del Cargo *</label>
                                                                        <textarea class="form-control" name="observaciones" 
                                                                                rows="3" required></textarea>
                                                                    </div>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                                                    <button type="submit" class="btn btn-danger">Registrar Cargo</button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>

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
            <h5 class="mb-0">Todas las Cuentas por Pagar</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>Proveedor</th>
                            <th>Compra</th>
                            <th>Fecha Venc.</th>
                            <th>Importe</th>
                            <th>Saldo</th>
                            <th>Estado</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($cxp as $cuenta)
                        <tr>
                            <td>{{ $cuenta->proveedor->nombre }}</td>
                            <td>{{ $cuenta->compra->referencia }}</td>
                            <td>{{ $cuenta->fecha_venc->format('d/m/Y') }}</td>
                            <td class="text-end">${{ number_format($cuenta->importe, 2) }}</td>
                            <td class="text-end">${{ number_format($cuenta->saldo, 2) }}</td>
                            <td>
                                <span class="badge bg-{{ 
                                    $cuenta->estado == 'pagado' ? 'success' : 
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
    <!-- Agregar esto después de la tabla principal -->

<div class="card mt-4">
    <div class="card-header bg-primary text-white">
        <h5 class="mb-0">Movimientos de Cuentas por Pagar</h5>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th>Proveedor</th>
                        <th>Compra</th>
                        <th>Fecha Movimiento</th>
                        <th>Tipo</th>
                        <th>Importe</th>
                        <th>Observaciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($cxp as $cuenta)
                        @foreach($cuenta->movimientos as $movimiento)
                        <tr>
                            <td>{{ $cuenta->proveedor->nombre }}</td>
                            <td>{{ $cuenta->compra->referencia }}</td>
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
