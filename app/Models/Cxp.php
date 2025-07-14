<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cxp extends Model
{
    use HasFactory;

    protected $table = 'cxp';

    protected $fillable = [
        'proveedor_id',
        'compra_id',
        'fecha_venc',
        'importe',
        'saldo',
        'estado'
    ];

    protected $casts = [
        'fecha_venc' => 'date',
        'importe' => 'decimal:2',
        'saldo' => 'decimal:2',
    ];

    public function proveedor()
    {
        return $this->belongsTo(Proveedor::class);
    }

    public function compra()
    {
        return $this->belongsTo(Compra::class);
    }
    public function movimientos()
    {
        return $this->hasMany(DetCxp::class);
    }
}