@extends('layouts.app')

@section('title', 'Detalle del Cliente')

@section('content')
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1>Detalle del Cliente</h1>
            <div>
                <a href="{{ route('clientes.edit', $cliente) }}" class="btn btn-warning">
                    <i class="bi bi-pencil"></i> Editar
                </a>
                <a href="{{ route('clientes.index') }}" class="btn btn-secondary">
                    <i class="bi bi-arrow-left"></i> Volver
                </a>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <h5 class="card-title">{{ $cliente->nombre }}</h5>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item">
                        <strong>Domicilio:</strong> {{ $cliente->domicilio }}
                    </li>
                    <li class="list-group-item">
                        <strong>Ciudad:</strong> {{ $cliente->ciudad }}
                    </li>
                    <li class="list-group-item">
                        <strong>Saldo:</strong> ${{ number_format($cliente->saldo, 2) }}
                    </li>
                    <li class="list-group-item">
                        <strong>Estado:</strong> 
                        <span class="badge bg-{{ $cliente->estado == 'activo' ? 'success' : 'secondary' }}">
                            {{ ucfirst($cliente->estado) }}
                        </span>
                    </li>
                    <li class="list-group-item">
                        <strong>Creado:</strong> {{ $cliente->created_at->format('d/m/Y H:i') }}
                    </li>
                    <li class="list-group-item">
                        <strong>Actualizado:</strong> {{ $cliente->updated_at->format('d/m/Y H:i') }}
                    </li>
                </ul>
            </div>
        </div>
    </div>
@endsection