@extends('layouts.app')

@section('title', 'Inventario de Artículos')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Inventario de Artículos</h1>
    </div>
    {{-- @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif --}}

    <div class="table-responsive">
        <table class="table table-striped table-hover">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Artículo</th>
                    <th>Variedad</th>
                    <th>Existencia</th>
                    <th>Precio Lista</th>
                    <th>Precio Mínimo</th>
                    <th>Costo</th>
                    <th>Estado</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($inventarios as $inventario)
                <tr>
                    <td>{{ $inventario->id }}</td>
                    <td>{{ $inventario->articulo->articulo }}</td>
                    <td>{{ $inventario->variedad }}</td>
                    <td>{{ number_format($inventario->existencia, 2) }}</td>
                    <td>${{ number_format($inventario->preciolst, 2) }}</td>
                    <td>${{ number_format($inventario->preciomin, 2) }}</td>
                    <td>${{ number_format($inventario->costo, 2) }}</td>
                    <td>
                        <span class="badge bg-{{ $inventario->estado == 'activo' ? 'success' : 'secondary' }}">
                            {{ ucfirst($inventario->estado) }}
                        </span>
                    </td>
                    <td>
                        <button class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#preciosModal{{ $inventario->id }}">
                            <i class="bi bi-currency-dollar"></i> Precios
                        </button>
                                            
                        <a href="{{ route('kardex.inventario', $inventario->id) }}" class="btn btn-sm btn-info">
                            <i class="bi bi-list-check"></i> Kardex
                        </a>
                    </td>                    
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
<!-- Modal para modificar precios -->
<div class="modal fade" id="preciosModal{{ $inventario->id }}" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Modifica Precios</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('inventarios.precios', $inventario) }}" method="POST">
                @csrf                
                <div class="modal-body">
                    <input type="hidden" name="id" value=" {{ $inventario->id }}">
                    <div class="mb-3">
                        <label for="preciolst" class="form-label">Precio Lista</label>
                        <input type="text" class="form-control" id="preciolst" name="preciolst" value=" {{ $inventario->preciolst }} " required>
                    </div>
                    <div class="mb-3">
                        <label for="preciomin" class="form-label">Precio Mínimo</label>
                        <input type="text" class="form-control money-input" id="preciomin" name="preciomin" value=" {{ $inventario->preciomin }} " required>
                    </div>
                    <div class="mb-3">
                        <label for="costo" class="form-label">Costo</label>
                        <input type="text" class="form-control money-input" id="costo" name="costo" value=" {{ $inventario->costo }} " readonly>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection