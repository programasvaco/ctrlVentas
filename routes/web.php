<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ArticuloController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\ProveedorController;
use App\Http\Controllers\InventarioController;
use App\Http\Controllers\CompraController;
use App\Http\Controllers\CxpController;
use App\Http\Controllers\KardexController;
use App\Http\Controllers\VentaController;
use App\Http\Controllers\CxcController;
use App\Http\Controllers\CajaController;
use App\Http\Controllers\PagoCxcController;
use App\Http\Controllers\CorteCajaController;

Route::get('/', function () {
    return redirect()->route('articulos.index');
});

Route::resource('articulos', ArticuloController::class);
Route::resource('clientes', ClienteController::class);
Route::prefix('proveedores')->name('proveedores.')->group(function () {
    Route::get('/', [ProveedorController::class, 'index'])->name('index');
    Route::get('/crear', [ProveedorController::class, 'create'])->name('create');
    Route::post('/', [ProveedorController::class, 'store'])->name('store');
    Route::get('/{proveedor}', [ProveedorController::class, 'show'])->name('show');
    Route::get('/{proveedor}/editar', [ProveedorController::class, 'edit'])->name('edit');
    Route::put('/{proveedor}', [ProveedorController::class, 'update'])->name('update');
    Route::delete('/{proveedor}', [ProveedorController::class, 'destroy'])->name('destroy');
});
Route::get('inventarios', [InventarioController::class, 'index'])->name('inventarios.index');
Route::post('inventarios/{inventario}/precios', [InventarioController::class, 'actPrecios'])->name('inventarios.precios');
Route::resource('compras', CompraController::class)->except(['edit', 'update', 'destroy']);
Route::post('compras/{compra}/completar', [CompraController::class, 'completar'])->name('compras.completar');
Route::get('cxp', [CxpController::class, 'index'])->name('cxp.index');
Route::post('cxp/{cuenta}/pagar', [CxpController::class, 'registrarPago'])->name('cxp.pagar');
Route::post('cxp/{cuenta}/cargar', [CxpController::class, 'registrarCargo'])->name('cxp.cargar');
Route::get('kardex', KardexController::class)->name('kardex.index');
Route::get('kardex/inventario/{inventario}', KardexController::class)->name('kardex.inventario');
Route::resource('ventas', VentaController::class)->except(['edit', 'update', 'destroy']);
Route::get('ventas/{venta}/imprimirFiscal', [VentaController::class, 'imprimirFiscal'])->name('ventas.imprimirFiscal');
Route::get('cxc', CxcController::class)->name('cxc.index');
Route::get('caja', CajaController::class)->name('caja.index');
Route::get('cxc/{cxc}/pagos/create', [PagoCxcController::class, 'create'])->name('cxc.pagos.create');
Route::post('cxc/{cxc}/pagos', [PagoCxcController::class, 'store'])->name('cxc.pagos.store');
Route::get('caja/salidas/create', [CajaController::class, 'createSalida'])->name('caja.salidas.create');
Route::post('caja/salidas', [CajaController::class, 'storeSalida'])->name('caja.salidas.store');
Route::prefix('cortes')->group(function () {
    Route::get('/', [CorteCajaController::class, 'index'])->name('cortes.index');
    Route::post('/', [CorteCajaController::class, 'store'])->name('cortes.store');
    Route::get('/{id}', [CorteCajaController::class, 'show'])->name('cortes.show');
});