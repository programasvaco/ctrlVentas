@extends('layouts.app')

@section('title', 'Lista de Articulos')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Lista de Articulos</h1>
        <a href="{{ route('articulos.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle"></i> Nuevo Artículo
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
                    <th>Imagen</th>
                    <th>Artículo</th>
                    <th>Unidad</th>
                    <th>Estado</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($articulos as $articulo)
                <tr>
                    <td>{{ $articulo->id }}</td>
                    <td>
                        @if($articulo->imagen)
                            <img src="{{ asset($articulo->imagen) }}" alt="{{ $articulo->articulo }}" width="50" class="img-thumbnail">
                        @else
                            <span class="text-muted">Sin imagen</span>
                        @endif
                    </td>
                    <td>{{ $articulo->articulo }}</td>
                    <td>{{ $articulo->unidad }}</td>
                    <td>
                        <span class="badge bg-{{ $articulo->estado == 'activo' ? 'success' : 'secondary' }}">
                            {{ ucfirst($articulo->estado) }}
                        </span>
                    </td>
                    <td>
                        <div class="d-flex gap-2">
                            <a href="{{ route('articulos.show', $articulo) }}" class="btn btn-sm btn-info">
                                <i class="bi bi-eye"></i>
                            </a>
                            <a href="{{ route('articulos.edit', $articulo) }}" class="btn btn-sm btn-warning">
                                <i class="bi bi-pencil"></i>
                            </a>
                            <form action="{{ route('articulos.destroy', $articulo) }}" method="POST" onsubmit="return confirm('¿Estás seguro de eliminar este artículo?')">
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