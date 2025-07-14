@extends('layouts.app')

@section('title', 'Detalle de Compra')

@section('content')
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1>Detalle de Compra</h1>
            <div>
                @if($compra->estado == 'pendiente')
                <form action="{{ route('compras.completar', $compra) }}" method="POST" class="d-inline">
                    @csrf
                    <button type="submit" class="btn btn-success me-2">
                        <i class="bi bi-check-circle"></i> Completar Compra
                    </button>
                </form>
                @endif
                <a href="{{ route('compras.index') }}" class="btn btn-secondary">
                    <i class="bi bi-arrow-left"></i> Volver
                </a>
            </div>
        </div>

        <div class="card mb-4">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <h5 class="card-title">Información de la Compra</h5>
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item">
                                <strong>Referencia:</strong> {{ $compra->referencia }}
                            </li>
                            <li class="list-group-item">
                                <strong>Proveedor:</strong> {{ $compra->proveedor->nombre }}
                            </li>
                            <li class="list-group-item">
                                <strong>Estado:</strong> 
                                <span class="badge bg-{{ 
                                    $compra->estado == 'completada' ? 'success' : 
                                    ($compra->estado == 'cancelada' ? 'danger' : 'warning') 
                                }}">
                                    {{ ucfirst($compra->estado) }}
                                </span>
                            </li>
                        </ul>
                    </div>
                    <div class="col-md-6">
                        <h5 class="card-title">Totales</h5>
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item">
                                <strong>Total:</strong> ${{ number_format($compra->total, 2) }}
                            </li>
                            <li class="list-group-item">
                                <strong>Fecha:</strong> {{ $compra->created_at->format('d/m/Y H:i') }}
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Artículos Comprados</h5>
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Artículo</th>
                                <th>Variedad</th>
                                <th>Cantidad</th>
                                <th>Costo Unitario</th>
                                <th>Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($compra->detalles as $detalle)
                            <tr>
                                <td>{{ $detalle->articulo->articulo }}</td>
                                <td>{{ $detalle->variedad }}</td>
                                <td>{{ number_format($detalle->cantidad, 2) }}</td>
                                <td>${{ number_format($detalle->costo, 2) }}</td>
                                <td>${{ number_format($detalle->cantidad * $detalle->costo, 2) }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection