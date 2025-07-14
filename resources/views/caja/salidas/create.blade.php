@extends('layouts.app')

@section('title', 'Registrar Salida de Caja')

@section('content')
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1>Registrar Salida de Caja</h1>
            <a href="{{ route('caja.index') }}" class="btn btn-secondary">
                <i class="bi bi-arrow-left"></i> Volver
            </a>
        </div>

        <div class="card">
            <div class="card-body">
                <form action="{{ route('caja.salidas.store') }}" method="POST">
                    @csrf

                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="fecha" class="form-label">Fecha *</label>
                            <input type="date" class="form-control" id="fecha" name="fecha" 
                                   value="{{ old('fecha', now()->format('Y-m-d')) }}" required>
                        </div>

                        <div class="col-md-6">
                            <label for="tipo_salida" class="form-label">Tipo de Salida *</label>
                            <select class="form-select" id="tipo_salida" name="tipo_salida" required>
                                <option value="gasto">Gasto</option>
                                <option value="retiro">Retiro</option>
                            </select>
                        </div>

                        <div class="col-12">
                            <label for="concepto" class="form-label">Concepto *</label>
                            <input type="text" class="form-control" id="concepto" name="concepto" required>
                            <small class="text-muted">Ej: Pago de servicios, Retiro de socio, etc.</small>
                        </div>

                        <div class="col-md-6">
                            <label for="cantidad" class="form-label">Cantidad *</label>
                            <input type="number" step="0.01" class="form-control" id="cantidad" 
                                   name="cantidad" min="0.01" required>
                        </div>

                        <div class="col-12 mt-4">
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-save"></i> Registrar Salida
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection