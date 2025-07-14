@extends('layouts.app')

@section('title', 'Registrar Nueva Compra')

@section('content')
    <div class="container">
        <h1>Registrar Nueva Compra</h1>

        <form id="compraForm" action="{{ route('compras.store') }}" method="POST">
            @csrf

            <div class="row g-3 mb-4">
                <div class="col-md-6">
                    <label for="proveedor_id" class="form-label">Proveedor *</label>
                    <select class="form-select" id="proveedor_id" name="proveedor_id" required>
                        <option value="">Seleccione un proveedor</option>
                        @foreach($proveedores as $proveedor)
                        <option value="{{ $proveedor->id }}">{{ $proveedor->nombre }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-6">
                    <label for="referencia" class="form-label">Referencia</label>
                    <input type="text" class="form-control" id="referencia" name="referencia" placeholder="Dejar en blanco para generar automáticamente">
                </div>
            </div>

            <h4 class="mb-3">Artículos Comprados</h4>
            <div id="detallesContainer">
                <div class="detalle-item row g-3 mb-3">
                    <div class="col-md-4">
                        <label class="form-label">Artículo *</label>
                        <select class="form-select articulo-select" name="detalles[0][articulo_id]" required>
                            <option value="">Seleccione un artículo</option>
                            @foreach($articulos as $articulo)
                            <option value="{{ $articulo->id }}">{{ $articulo->articulo }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">Variedad *</label>
                        <input type="text" class="form-control" name="detalles[0][variedad]" required>
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">Cantidad *</label>
                        <input type="number" step="0.01" class="form-control cantidad" name="detalles[0][cantidad]" required>
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">Costo *</label>
                        <input type="number" step="0.01" class="form-control costo" name="detalles[0][costo]" required>
                    </div>
                    <div class="col-md-2 d-flex align-items-end">
                        <button type="button" class="btn btn-danger btn-remove-detalle" disabled>
                            <i class="bi bi-trash"></i>
                        </button>
                    </div>
                </div>
            </div>

            <div class="mb-4">
                <button type="button" id="btnAddDetalle" class="btn btn-secondary">
                    <i class="bi bi-plus-circle"></i> Agregar Artículo
                </button>
            </div>

            <div class="row">
                <div class="col-12">
                    <button type="submit" class="btn btn-primary">Registrar Compra</button>
                    <a href="{{ route('compras.index') }}" class="btn btn-secondary">Cancelar</a>
                </div>
            </div>
        </form>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            let detalleCount = 1;
            
            // Agregar nuevo detalle
            document.getElementById('btnAddDetalle').addEventListener('click', function() {
                const newDetalle = document.querySelector('.detalle-item').cloneNode(true);
                const newIndex = detalleCount++;
                
                // Actualizar nombres y limpiar valores
                newDetalle.querySelectorAll('[name]').forEach(el => {
                    const name = el.getAttribute('name').replace('[0]', `[${newIndex}]`);
                    el.setAttribute('name', name);
                    if (el.tagName === 'INPUT' && el.type !== 'hidden') {
                        el.value = '';
                    } else if (el.tagName === 'SELECT') {
                        el.selectedIndex = 0;
                    }
                });
                
                // Habilitar botón de eliminar
                newDetalle.querySelector('.btn-remove-detalle').disabled = false;
                newDetalle.querySelector('.btn-remove-detalle').addEventListener('click', function() {
                    newDetalle.remove();
                });
                
                document.getElementById('detallesContainer').appendChild(newDetalle);
            });
            
            // Eliminar detalle
            document.addEventListener('click', function(e) {
                if (e.target.classList.contains('btn-remove-detalle')) {
                    e.target.closest('.detalle-item').remove();
                }
            });
        });
    </script>
@endsection