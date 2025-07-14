<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetCompra extends Model
{
    use HasFactory;

    protected $fillable = [
        'compra_id',
        'articulo_id',
        'variedad',
        'cantidad',
        'costo'
    ];

    protected $casts = [
        'cantidad' => 'decimal:2',
        'costo' => 'decimal:2',
    ];

    public function compra()
    {
        return $this->belongsTo(Compra::class);
    }

    public function articulo()
    {
        return $this->belongsTo(Articulo::class);
    }
}