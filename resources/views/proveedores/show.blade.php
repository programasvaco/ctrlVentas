@extends('layouts.app')

@section('title', 'Detalle del Proveedor')

@section('content')
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1>Detalle del Proveedor</h1>
            <div>
                <a href="{{ route('proveedores.edit', $proveedor) }}" class="btn btn-warning">
                    <i class="bi bi-pencil"></i> Editar
                </a>
                <a href="{{ route('proveedores.index') }}" class="btn btn-secondary">
                    <i class="bi bi-arrow-left"></i> Volver
                </a>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <h5 class="card-title">{{ $proveedor->nombre }}</h5>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item">
                        <strong>Domicilio:</strong> {{ $proveedor->domicilio ?? 'N/A' }}
                    </li>
                    <li class="list-group-item">
                        <strong>Ciudad:</strong> {{ $proveedor->ciudad }}
                    </li>
                    <li class="list-group-item">
                        <strong>Saldo:</strong> ${{ number_format($proveedor->saldo, 2) }}
                    </li>
                    <li class="list-group-item">
                        <strong>Estado:</strong> 
                        <span class="badge bg-{{ $proveedor->estado == 'activo' ? 'success' : 'secondary' }}">
                            {{ ucfirst($proveedor->estado) }}
                        </span>
                    </li>
                    <li class="list-group-item">
                        <strong>Creado:</strong> {{ $proveedor->created_at->format('d/m/Y H:i') }}
                    </li>
                    <li class="list-group-item">
                        <strong>Actualizado:</strong> {{ $proveedor->updated_at->format('d/m/Y H:i') }}
                    </li>
                </ul>
            </div>
        </div>
    </div>
@endsection