@extends('layouts.app')

@section('title', 'Editar Articulo')

@section('content')
    <div class="container">
        <h1>Editar Articulo</h1>

        <form action="{{ route('articulos.update', $articulo) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="row g-3">
                <div class="col-md-6">
                    <label for="articulo" class="form-label">Artículo</label>
                    <input type="text" class="form-control" id="articulo" name="articulo" value="{{ $articulo->articulo }}" required>
                </div>

                <div class="col-md-6">
                    <label for="unidad" class="form-label">Unidad</label>
                    <input type="text" class="form-control" id="unidad" name="unidad" value="{{ $articulo->unidad }}" required>
                </div>

                <div class="col-md-6">
                    <label for="estado" class="form-label">Estado</label>
                    <select class="form-select" id="estado" name="estado" required>
                        <option value="activo" {{ $articulo->estado == 'activo' ? 'selected' : '' }}>Activo</option>
                        <option value="inactivo" {{ $articulo->estado == 'inactivo' ? 'selected' : '' }}>Inactivo</option>
                    </select>
                </div>

                <div class="col-md-6">
                    <label for="imagen" class="form-label">Imagen</label>
                    <input type="file" class="form-control" id="imagen" name="imagen">
                    
                    @if($articulo->imagen)
                        <div class="mt-2">
                            <img src="{{ asset($articulo->imagen) }}" alt="{{ $articulo->articulo }}" width="100" class="img-thumbnail">
                            <p class="text-muted small mt-1">Imagen actual</p>
                        </div>
                    @endif
                </div>

                <div class="col-12">
                    <button type="submit" class="btn btn-primary">Actualizar</button>
                    <a href="{{ route('articulos.index') }}" class="btn btn-secondary">Cancelar</a>
                </div>
            </div>
        </form>
    </div>
@endsection