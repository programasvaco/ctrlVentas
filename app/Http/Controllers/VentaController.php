<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Models\Inventario;
use App\Models\Venta;
use App\Models\VentaDetalle;
use App\Models\Kardex;
use App\Models\Cxc;
use App\Models\Caja;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Mike42\Escpos\PrintConnectors\NetworkPrintConnector;
use Mike42\Escpos\Printer;

class VentaController extends Controller
{
    public function index()
    {
        $ventas = Venta::with('cliente')->orderBy('created_at', 'desc')->get();
        return view('ventas.index', compact('ventas'));
    }

    public function create()
    {
        $clientes = Cliente::where('estado', 'activo')->get();
        $inventarios = Inventario::with('articulo')
            ->where('estado', 'activo')
            ->where('existencia', '>', 0)
            ->get();
            
        return view('ventas.create', compact('clientes', 'inventarios'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'cliente_id' => 'required|exists:clientes,id',
            'forma_pago' => 'required|in:contado,credito',
            'detalles' => 'required|array|min:1',
            'detalles.*.inventario_id' => 'required|exists:inventarios,id',
            'detalles.*.cantidad' => 'required|numeric|min:0.01',
            'detalles.*.precio' => 'required|numeric|min:0.01',
        ]);

        // Generar folio único
        $folio = 'V-' . Str::upper(Str::random(8));

        // Calcular total
        $total = collect($request->detalles)->sum(function ($detalle) {
            return $detalle['cantidad'] * $detalle['precio'];
        });

        // Crear la venta
        $venta = Venta::create([
            'folio' => $folio,
            'fecha' => now(),
            'cliente_id' => $request->cliente_id,
            'forma_pago' => $request->forma_pago,
            'total' => $total
        ]);
        // Si es crédito, crear cuenta por cobrar
        if ($request->forma_pago === 'credito') {
            Cxc::create([
                'cliente_id' => $request->cliente_id,
                'venta_id' => $venta->id,
                'fecha_vencimiento' => now()->addDays(30), // 30 días de plazo por defecto
                'importe' => $total,
                'saldo' => $total,
                'estado' => 'pendiente'
            ]);
            // Actualizar saldo del cliente
            $cliente = Cliente::find($request->cliente_id);
            $cliente->increment('saldo', $total);
        }
        // Si es contado, registrar en caja
        if ($request->forma_pago === 'contado') {
            Caja::create([
                'tipo' => 'entrada',
                'doc_relacionado' => $venta->folio,
                'fecha' => now(),
                'cantidad' => $total,
                'concepto' => 'Venta al contado ' . $venta->folio
            ]);
        }

        // Crear detalles y actualizar inventario
        foreach ($request->detalles as $detalle) {
            $inventario = Inventario::find($detalle['inventario_id']);

            VentaDetalle::create([
                'venta_id' => $venta->id,
                'inventario_id' => $detalle['inventario_id'],
                'cantidad' => $detalle['cantidad'],
                'precio' => $detalle['precio']
            ]);

            // Actualizar inventario
            $inventario->decrement('existencia', $detalle['cantidad']);

            // Registrar movimiento en Kardex
            Kardex::create([
                'inventario_id' => $detalle['inventario_id'],
                'tipo' => 'salida',
                'fecha' => now(),
                'doc_relacionado' => $folio,
                'cantidad' => $detalle['cantidad'],
                'costo' => $inventario->costo
            ]);
        }

        return redirect()->route('ventas.index')->with('success', 'Venta registrada correctamente.');
    }

    public function show(Venta $venta)
    {
        $venta->load('cliente', 'detalles.inventario.articulo');
        return view('ventas.show', compact('venta'));
    }

    public function imprimirFiscal(Venta $venta)
    {
        try {
            // new WindowsPrintConnector("smb://computadora/impresora");
            $connector = new NetworkPrintConnector("192.168.1.25", 9100);
            $printer = new Printer($connector);
            
            // Configurar encabezado
            $printer->setJustification(Printer::JUSTIFY_CENTER);
            $printer->text("** ".config('app.name')." **\n");
            $printer->text("Dirección: " . config('app.direccion', 'Calle Falsa 123') . "\n");
            $printer->text("Teléfono: " . config('app.telefono', '123-456-7890') . "\n");
            $printer->text("--------------------------------\n");
            // Datos del ticket (folio, fecha, cliente)
            $printer->text("Ticket: " . $venta->folio . "\n");
            $printer->text("Fecha: " . $venta->created_at->format('d/m/Y H:i') . "\n");
            // Datos del cliente (si existe)
            if ($venta->cliente) {
                $printer->text("Cliente: " . $venta->cliente->nombre . "\n");
            } else {
                $printer->text("Cliente: PÚBLICO GENERAL\n");
            }
            $printer->text("--------------------------------\n");
            // Detalles de venta
            $printer->setJustification(Printer::JUSTIFY_LEFT);
            foreach($venta->detalles as $detalle) {
                $printer->text(sprintf("%-5s %-20s $%7.2f\n", 
                    $detalle->cantidad,  
                    substr($detalle->inventario->articulo->articulo, 0, 20), 
                    $detalle->precio));
            }
            
            // Total y cierre
            $printer->text("----------------------------\n");
            $printer->setJustification(Printer::JUSTIFY_RIGHT);
            $printer->text("TOTAL: $" . number_format($venta->total, 2) . "\n");
            $printer->text("--------------------------------\n");
        
            // Mensaje final (opcional)
            $printer->setJustification(Printer::JUSTIFY_CENTER);
            $printer->text("¡Gracias por su compra!\n");
            
            $printer->feed(2);
            $printer->cut();
            $printer->close();
            
            return back()->with('success', 'Ticket enviado a impresora');
        } catch (\Exception $e) {
            return back()->with('error', 'Error al imprimir: '.$e->getMessage());
        }
    }
}