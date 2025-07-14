<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VentaDetalle extends Model
{
    use HasFactory;

    protected $fillable = [
        'venta_id',
        'inventario_id',
        'cantidad',
        'precio'
    ];

    protected $casts = [
        'cantidad' => 'decimal:2',
        'precio' => 'decimal:2',
    ];

    public function venta()
    {
        return $this->belongsTo(Venta::class);
    }

    public function inventario()
    {
        return $this->belongsTo(Inventario::class);
    }
}