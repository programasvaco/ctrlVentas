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
        Schema::create('det_cxc', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cxc_id')->constrained('cxc')->onDelete('cascade');
            $table->date('fecha_pago');
            $table->decimal('importe', 12, 2);
            $table->enum('tipo', ['cargo', 'abono']);
            $table->text('observaciones')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('det_cxc');
    }
};
