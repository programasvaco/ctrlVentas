<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inventario extends Model
{
    use HasFactory;

    protected $fillable = [
        'articulo_id',
        'variedad',
        'existencia',
        'preciolst',
        'preciomin',
        'costo',
        'estado'
    ];

    protected $casts = [
        'existencia' => 'decimal:2',
        'preciolst' => 'decimal:2',
        'preciomin' => 'decimal:2',
        'costo' => 'decimal:2',
    ];

    public function articulo()
    {
        return $this->belongsTo(Articulo::class);
    }
    public function movimientos()
    {
        return $this->hasMany(Kardex::class);
    }
}