@extends('layouts.app')

@section('content')
    <h1>Cortes de Caja</h1>

    <div class="card mb-4">
        <div class="card-header">
            <h5>Movimientos pendientes de corte</h5>
        </div>
        <div class="card-body">    
            @if($movimientosSinCorte->count() > 0)
                <table class="table">
                    <thead>
                        <tr>
                            <th>Fecha</th>
                            <th>Tipo</th>
                            <th>Documento</th>
                            <th>Cantidad</th>
                            <th>Concepto</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($movimientosSinCorte as $movimiento)
                            <tr>
                                <td>{{ $movimiento->fecha }}</td>
                                <td>{{ $movimiento->tipo }}</td>
                                <td>{{ $movimiento->doc_relacionado }}</td>
                                <td>{{ number_format($movimiento->cantidad, 2) }}</td>
                                <td>{{ $movimiento->concepto }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                
                <form action="{{ route('cortes.store') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="notas">Notas:</label>
                        <textarea name="notas" id="notas" class="form-control"></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Generar Corte</button>
                </form>
            @else
                <div class="alert alert-info">No hay movimientos pendientes para generar un corte</div>
            @endif
        </div>
    </div>
    <div class="card mb-4">
        <div class="card-header">
            <h5>Listdo de cortes anteriores</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>Fecha</th>
                            <th>Entradas</th>
                            <th>Salidas</th>
                            <th>Saldo</th>
                            <th>Notas</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($corteCaja as $cortes)
                            <tr>
                                <td>{{ $cortes->fecha_inicio }}</td>
                                <td>{{ $cortes->total_entradas }}</td>
                                <td>{{ $cortes->total_salidas }}</td>
                                <td>{{ $cortes->saldo_final }}</td>
                                <td>{{ $cortes->notas }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection