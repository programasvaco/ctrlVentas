@extends('layouts.app')

@section('title', 'Lista de Ventas')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Lista de Ventas</h1>        
        <a href="{{ route('ventas.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle"></i> Nueva Venta
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
                    <th>Folio</th>
                    <th>Fecha</th>
                    <th>Cliente</th>
                    <th>Forma de Pago</th>
                    <th>Total</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($ventas as $venta)
                <tr>
                    <td>{{ $venta->folio }}</td>
                    <td>{{ $venta->fecha->format('d/m/Y') }}</td>
                    <td>{{ $venta->cliente->nombre }}</td>
                    <td>{{ ucfirst($venta->forma_pago) }}</td>
                    <td>${{ number_format($venta->total, 2) }}</td>
                    <td>
                        <a href="{{ route('ventas.show', $venta) }}" class="btn btn-sm btn-info">
                            <i class="bi bi-eye"></i> Detalle
                        </a>
                        <a href="{{ route('ventas.imprimirFiscal', $venta) }}" class="btn btn-primary">
                            <i class="bi bi-printer"></i> Imprimir Ticket
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection