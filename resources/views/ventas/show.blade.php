@extends('layouts.app')

@section('title', 'Detalle de Venta')

@section('content')
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1>Detalle de Venta</h1>
            <a href="{{ route('ventas.index') }}" class="btn btn-secondary">
                <i class="bi bi-arrow-left"></i> Volver
            </a>
        </div>

        <div class="card mb-4">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <h5 class="card-title">Información de la Venta</h5>
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item">
                                <strong>Folio:</strong> {{ $venta->folio }}
                            </li>
                            <li class="list-group-item">
                                <strong>Fecha:</strong> {{ $venta->fecha->format('d/m/Y') }}
                            </li>
                            <li class="list-group-item">
                                <strong>Cliente:</strong> {{ $venta->cliente->nombre }}
                            </li>
                            <li class="list-group-item">
                                <strong>Forma de Pago:</strong> {{ ucfirst($venta->forma_pago) }}
                            </li>
                        </ul>
                    </div>
                    <div class="col-md-6">
                        <h5 class="card-title">Totales</h5>
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item">
                                <strong>Total:</strong> ${{ number_format($venta->total, 2) }}
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Artículos Vendidos</h5>
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Artículo</th>
                                <th>Variedad</th>
                                <th>Cantidad</th>
                                <th>Precio Unitario</th>
                                <th>Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($venta->detalles as $detalle)
                            <tr>
                                <td>{{ $detalle->inventario->articulo->articulo }}</td>
                                <td>{{ $detalle->inventario->variedad }}</td>
                                <td>{{ number_format($detalle->cantidad, 2) }}</td>
                                <td>${{ number_format($detalle->precio, 2) }}</td>
                                <td>${{ number_format($detalle->cantidad * $detalle->precio, 2) }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection