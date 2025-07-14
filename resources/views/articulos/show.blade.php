@extends('layouts.app')

@section('title', 'Detalle de Articulo')

@section('content')
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1>Detalle de Articulo</h1>
            <div>
                <a href="{{ route('articulos.edit', $articulo) }}" class="btn btn-warning">
                    <i class="bi bi-pencil"></i> Editar
                </a>
                <a href="{{ route('articulos.index') }}" class="btn btn-secondary">
                    <i class="bi bi-arrow-left"></i> Volver
                </a>
            </div>
        </div>

        <div class="card">
            <div class="row g-0">
                <div class="col-md-4">
                    @if($articulo->imagen)
                        <img src="{{ asset($articulo->imagen) }}" class="img-fluid rounded-start" alt="{{ $articulo->articulo }}">
                    @else
                        <div class="d-flex align-items-center justify-content-center bg-light" style="height: 100%;">
                            <span class="text-muted">Sin imagen</span>
                        </div>
                    @endif
                </div>
                <div class="col-md-8">
                    <div class="card-body">
                        <h5 class="card-title">{{ $articulo->articulo }}</h5>
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item">
                                <strong>Unidad:</strong> {{ $articulo->unidad }}
                            </li>
                            <li class="list-group-item">
                                <strong>Estado:</strong> 
                                <span class="badge bg-{{ $articulo->estado == 'activo' ? 'success' : 'secondary' }}">
                                    {{ ucfirst($articulo->estado) }}
                                </span>
                            </li>
                            <li class="list-group-item">
                                <strong>Creado:</strong> {{ $articulo->created_at->format('d/m/Y H:i') }}
                            </li>
                            <li class="list-group-item">
                                <strong>Actualizado:</strong> {{ $articulo->updated_at->format('d/m/Y H:i') }}
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection