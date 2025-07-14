@extends('layouts.app')

@section('title', 'Crear Nuevo Cliente')

@section('content')
    <div class="container">
        <h1>Crear Nuevo Cliente</h1>

        <form action="{{ route('clientes.store') }}" method="POST">
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
                    <label for="domicilio" class="form-label">Domicilio</label>
                    <input type="text" class="form-control" id="domicilio" name="domicilio" required>
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

                <div class="col-12">
                    <button type="submit" class="btn btn-primary">Guardar</button>
                    <a href="{{ route('clientes.index') }}" class="btn btn-secondary">Cancelar</a>
                </div>
            </div>
        </form>
    </div>
@endsection