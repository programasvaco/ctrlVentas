@extends('layouts.app')

@section('title', 'Lista de Proveedores')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Lista de Proveedores</h1>
        <a href="{{ route('proveedores.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle"></i> Nuevo Proveedor
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="table-responsive">
        <table class="table table-striped table-hover">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Domicilio</th>
                    <th>Ciudad</th>
                    <th>Saldo</th>
                    <th>Estado</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($proveedores as $proveedor)
                <tr>
                    <td>{{ $proveedor->id }}</td>
                    <td>{{ $proveedor->nombre }}</td>
                    <td>{{ $proveedor->domicilio ?? 'N/A' }}</td>
                    <td>{{ $proveedor->ciudad }}</td>
                    <td>${{ number_format($proveedor->saldo, 2) }}</td>
                    <td>
                        <span class="badge bg-{{ $proveedor->estado == 'activo' ? 'success' : 'secondary' }}">
                            {{ ucfirst($proveedor->estado) }}
                        </span>
                    </td>
                    <td>
                        <div class="d-flex gap-2">
                            <a href="{{ route('proveedores.show', $proveedor) }}" class="btn btn-sm btn-info">
                                <i class="bi bi-eye"></i>
                            </a>
                            <a href="{{ route('proveedores.edit', $proveedor) }}" class="btn btn-sm btn-warning">
                                <i class="bi bi-pencil"></i>
                            </a>
                            <form action="{{ route('proveedores.destroy', $proveedor) }}" method="POST" onsubmit="return confirm('¿Estás seguro de eliminar este proveedor?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection