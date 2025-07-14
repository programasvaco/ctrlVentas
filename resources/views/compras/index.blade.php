@extends('layouts.app')

@section('title', 'Lista de Compras')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Lista de Compras</h1>
        <a href="{{ route('compras.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle"></i> Nueva Compra
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
                    <th>Referencia</th>
                    <th>Proveedor</th>
                    <th>Total</th>
                    <th>Estado</th>
                    <th>Fecha</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($compras as $compra)
                <tr>
                    <td>{{ $compra->referencia }}</td>
                    <td>{{ $compra->proveedor->nombre }}</td>
                    <td>${{ number_format($compra->total, 2) }}</td>
                    <td>
                        <span class="badge bg-{{ 
                            $compra->estado == 'completada' ? 'success' : 
                            ($compra->estado == 'cancelada' ? 'danger' : 'warning') 
                        }}">
                            {{ ucfirst($compra->estado) }}
                        </span>
                    </td>
                    <td>{{ $compra->created_at->format('d/m/Y H:i') }}</td>
                    <td>
                        <div class="d-flex gap-2">
                            <a href="{{ route('compras.show', $compra) }}" class="btn btn-sm btn-info">
                                <i class="bi bi-eye"></i>
                            </a>
                            @if($compra->estado == 'pendiente')
                            <form action="{{ route('compras.completar', $compra) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-sm btn-success">
                                    <i class="bi bi-check-circle"></i> Completar
                                </button>
                            </form>
                            @endif
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection