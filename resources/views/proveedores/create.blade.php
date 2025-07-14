@extends('layouts.app')

@section('title', 'Crear Nuevo Proveedor')

@section('content')
    <div class="container">
        <h1>Crear Nuevo Proveedor</h1>

        <form action="{{ route('proveedores.store') }}" method="POST">
            @csrf

            <div class="row g-3">
                <div class="col-md-6">
                    <label for="nombre" class="form-label">Nombre</label>
                    <input type="text" class="form-control" id="nombre" name="nombre" required>
                </div>

                <div class="col-md-6">
                    <label for="ciudad" class="form-label">Ciudad</label>
                    <input type="text" class="form-control" id="ciudad" name="ciudad" required>
                </div>

                <div class="col-12">
                    <label for="domicilio" class="form-label">Domicilio (opcional)</label>
                    <input type="text" class="form-control" id="domicilio" name="domicilio">
                </div>

                <div class="col-md-6">
                    <label for="saldo" class="form-label">Saldo</label>
                    <input type="number" step="0.01" class="form-control" id="saldo" name="saldo" value="0" required>
                </div>

                <div class="col-md-6">
                    <label for="estado" class="form-label">Estado</label>
                    <select class="form-select" id="estado" name="estado" required>
                        <option value="activo">Activo</option>
                        <option value="inactivo">Inactivo</option>
                    </select>
                </div>
                <div class="col-md-6">
                    <label for="dias_plazo" class="form-label">Días de Plazo</label>
                    <input type="number" class="form-control" id="dias_plazo" name="dias_plazo" value="{{ old('dias_plazo', $proveedor->dias_plazo ?? 30) }}" required>
                </div>

                <div class="col-12">
                    <button type="submit" class="btn btn-primary">Guardar</button>
                    <a href="{{ route('proveedores.index') }}" class="btn btn-secondary">Cancelar</a>
                </div>
            </div>
        </form>
    </div>
@endsection