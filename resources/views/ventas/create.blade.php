@extends('layouts.app')

@section('title', 'Registrar Nueva Venta')

@section('content')
    <div class="container">
        <h1>Registrar Nueva Venta</h1>

        <form id="ventaForm" action="{{ route('ventas.store') }}" method="POST">
            @csrf

            <div class="row g-3 mb-4">
                <div class="col-md-6">
                    <label for="cliente_id" class="form-label">Cliente *</label>
                    <select class="form-select" id="cliente_id" name="cliente_id" required>
                        <option value="">Seleccione un cliente</option>
                        @foreach($clientes as $cliente)
                        <option value="{{ $cliente->id }}">{{ $cliente->nombre }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-6">
                    <label for="forma_pago" class="form-label">Forma de Pago *</label>
                    <select class="form-select" id="forma_pago" name="forma_pago" required>
                        <option value="contado">Contado</option>
                        <option value="credito">Crédito</option>
                    </select>
                </div>
            </div>

            <h4 class="mb-3">Artículos Vendidos</h4>
            <div id="detallesContainer">
                <div class="detalle-item row g-3 mb-3">
                    <div class="col-md-5">
                        <label class="form-label">Artículo *</label>
                        <select class="form-select inventario-select" name="detalles[0][inventario_id]" required>
                            <option value="">Seleccione un artículo</option>
                            @foreach($inventarios as $inventario)
                            <option 
                                value="{{ $inventario->id }}"
                                data-precio="{{ $inventario->preciolst }}"
                                data-existencia="{{ $inventario->existencia }}">
                                {{ $inventario->articulo->articulo }} - {{ $inventario->variedad }} (Existencia: {{ $inventario->existencia }})
                            </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">Cantidad *</label>
                        <input type="number" step="0.01" class="form-control cantidad" name="detalles[0][cantidad]" required>
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">Precio *</label>
                        <input type="number" step="0.01" class="form-control precio" name="detalles[0][precio]" required>
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">Subtotal</label>
                        <input type="text" class="form-control subtotal" readonly>
                    </div>
                    <div class="col-md-1 d-flex align-items-end">
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
                <div class="col-md-6 offset-md-6">
                    <div class="d-flex justify-content-between mb-2">
                        <strong>Total:</strong>
                        <span id="totalVenta">$0.00</span>
                    </div>
                </div>
            </div>

            <div class="row mt-4">
                <div class="col-12">
                    <button type="submit" class="btn btn-primary">Registrar Venta</button>
                    <a href="{{ route('ventas.index') }}" class="btn btn-secondary">Cancelar</a>
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
                    calcularTotal();
                });
                
                // Configurar eventos para el nuevo detalle
                configurarEventosDetalle(newDetalle);
                
                document.getElementById('detallesContainer').appendChild(newDetalle);
            });
            
            // Eliminar detalle
            document.addEventListener('click', function(e) {
                if (e.target.classList.contains('btn-remove-detalle')) {
                    e.target.closest('.detalle-item').remove();
                    calcularTotal();
                }
            });
            
            // Configurar eventos para el primer detalle
            configurarEventosDetalle(document.querySelector('.detalle-item'));
            
            function configurarEventosDetalle(detalleElement) {
                const selectInventario = detalleElement.querySelector('.inventario-select');
                const inputCantidad = detalleElement.querySelector('.cantidad');
                const inputPrecio = detalleElement.querySelector('.precio');
                const inputSubtotal = detalleElement.querySelector('.subtotal');
                
                // Auto-completar precio al seleccionar artículo
                selectInventario.addEventListener('change', function() {
                    const selectedOption = this.options[this.selectedIndex];
                    const precio = selectedOption.getAttribute('data-precio');
                    const existencia = selectedOption.getAttribute('data-existencia');
                    
                    if (precio) {
                        inputPrecio.value = precio;
                    }
                    
                    calcularSubtotal(detalleElement);
                    calcularTotal();
                });
                
                // Calcular al cambiar cantidad o precio
                inputCantidad.addEventListener('input', function() {
                    calcularSubtotal(detalleElement);
                    calcularTotal();
                });
                
                inputPrecio.addEventListener('input', function() {
                    calcularSubtotal(detalleElement);
                    calcularTotal();
                });
            }
            
            function calcularSubtotal(detalleElement) {
                const cantidad = parseFloat(detalleElement.querySelector('.cantidad').value) || 0;
                const precio = parseFloat(detalleElement.querySelector('.precio').value) || 0;
                const subtotal = cantidad * precio;
                
                detalleElement.querySelector('.subtotal').value = '$' + subtotal.toFixed(2);
            }
            
            function calcularTotal() {
                let total = 0;
                
                document.querySelectorAll('.detalle-item').forEach(detalle => {
                    const cantidad = parseFloat(detalle.querySelector('.cantidad').value) || 0;
                    const precio = parseFloat(detalle.querySelector('.precio').value) || 0;
                    total += cantidad * precio;
                });
                
                document.getElementById('totalVenta').textContent = '$' + total.toFixed(2);
            }
        });
    </script>
@endsection