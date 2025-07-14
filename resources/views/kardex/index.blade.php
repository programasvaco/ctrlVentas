@extends('layouts.app')

@section('title', 'Kardex de Inventario')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>
            @if(isset($inventario))
                Kardex: {{ $inventario->articulo->articulo }} - {{ $inventario->variedad }}
            @else
                Kardex General
            @endif
        </h1>
        
        @if(isset($inventario))
        <a href="{{ route('kardex.index') }}" class="btn btn-secondary">
            <i class="bi bi-arrow-left"></i> Ver Todos
        </a>
        @endif
    </div>

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead class="table-dark">
                        <tr>
                            @if(!isset($inventario))
                            <th>Artículo</th>
                            <th>Variedad</th>
                            @endif
                            <th>Fecha</th>
                            <th>Tipo</th>
                            <th>Documento</th>
                            <th style="text-align: right">Cantidad</th>
                            <th style="text-align: right">Costo Unitario</th>
                            <th style="text-align: right">Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($kardex as $movimiento)
                        <tr>
                            @if(!isset($inventario))
                            <td>{{ $movimiento->inventario->articulo->articulo }}</td>
                            <td>{{ $movimiento->inventario->variedad }}</td>
                            @endif
                            <td>{{ $movimiento->fecha->format('d/m/Y') }}</td>
                            <td>
                                <span class="badge bg-{{ $movimiento->tipo == 'entrada' ? 'success' : 'danger' }}">
                                    {{ ucfirst($movimiento->tipo) }}
                                </span>
                            </td>
                            <td>{{ $movimiento->doc_relacionado }}</td>
                            <td class="text-end">{{ number_format($movimiento->cantidad, 2) }}</td>
                            <td class="text-end">${{ number_format($movimiento->costo, 2) }}</td>
                            <td class="text-end">${{ number_format($movimiento->cantidad * $movimiento->costo, 2) }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="mt-4">
                {{ $kardex->links() }}
            </div>
        </div>
    </div>
@endsection