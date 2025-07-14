@extends('layouts.app')

@section('title', 'Crear Nuevo Articulo')

@section('content')
    <div class="container">
        <h1>Crear Nuevo Articulo</h1>

        <form action="{{ route('articulos.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="row g-3">
                <div class="col-md-6">
                    <label for="articulo" class="form-label">Artículo</label>
                    <input type="text" class="form-control" id="articulo" name="articulo" required>
                </div>

                <div class="col-md-6">
                    <label for="unidad" class="form-label">Unidad</label>
                    <input type="text" class="form-control" id="unidad" name="unidad" required>
                </div>

                <div class="col-md-6">
                    <label for="estado" class="form-label">Estado</label>
                    <select class="form-select" id="estado" name="estado" required>
                        <option value="activo">Activo</option>
                        <option value="inactivo">Inactivo</option>
                    </select>
                </div>

                <div class="col-md-6">
                    <label for="imagen" class="form-label">Imagen</label>
                    <input type="file" class="form-control" id="imagen" name="imagen">
                </div>

                <div class="col-12">
                    <button type="submit" class="btn btn-primary">Guardar</button>
                    <a href="{{ route('articulos.index') }}" class="btn btn-secondary">Cancelar</a>
                </div>
            </div>
        </form>
    </div>
@endsection