<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('cxp', function (Blueprint $table) {
            $table->id();
            $table->foreignId('proveedor_id')->constrained('proveedores')->onDelete('cascade');
            $table->foreignId('compra_id')->constrained('compras')->onDelete('cascade');
            $table->date('fecha_venc');
            $table->decimal('importe', 12, 2);
            $table->decimal('saldo', 12, 2);
            $table->enum('estado', ['pendiente', 'pagado', 'parcial'])->default('pendiente');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cxp');
    }
};
