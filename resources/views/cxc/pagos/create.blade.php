@extends('layouts.app')

@section('title', 'Registrar Pago de CxC')

@section('content')
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1>Registrar Pago de Cuenta por Cobrar</h1>
            <a href="{{ route('cxc.index') }}" class="btn btn-secondary">
                <i class="bi bi-arrow-left"></i> Volver
            </a>
        </div>

        <div class="card">
            <div class="card-body">
                <div class="row mb-4">
                    <div class="col-md-6">
                        <h5>Información de la Cuenta</h5>
                        <ul class="list-group">
                            <li class="list-group-item">
                                <strong>Cliente:</strong> {{ $cxc->cliente->nombre }}
                            </li>
                            <li class="list-group-item">
                                <strong>Venta:</strong> {{ $cxc->venta->folio }}
                            </li>
                            <li class="list-group-item">
                                <strong>Saldo Actual:</strong> ${{ number_format($cxc->saldo, 2) }}
                            </li>
                        </ul>
                    </div>
                </div>

                <form action="{{ route('cxc.pagos.store', $cxc) }}" method="POST">
                    @csrf

                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="fecha_pago" class="form-label">Fecha de Pago *</label>
                            <input type="date" class="form-control" id="fecha_pago" name="fecha_pago" 
                                   value="{{ old('fecha_pago', now()->format('Y-m-d')) }}" required>
                        </div>

                        <div class="col-md-6">
                            <label for="importe" class="form-label">Importe *</label>
                            <input type="number" step="0.01" class="form-control" id="importe" name="importe" 
                                   min="0.01" max="{{ $cxc->saldo }}" required>
                        </div>

                        <div class="col-12">
                            <label for="observaciones" class="form-label">Observaciones</label>
                            <textarea class="form-control" id="observaciones" name="observaciones" rows="3">{{ old('observaciones') }}</textarea>
                        </div>

                        <div class="col-12">
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-cash"></i> Registrar Pago
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection