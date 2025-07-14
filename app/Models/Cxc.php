<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cxc extends Model
{
    use HasFactory;

    protected $table = 'cxc';

    protected $fillable = [
        'cliente_id',
        'venta_id',
        'fecha_vencimiento',
        'importe',
        'saldo',
        'estado'
    ];

    protected $casts = [
        'fecha_vencimiento' => 'date',
        'importe' => 'decimal:2',
        'saldo' => 'decimal:2',
    ];

    public function cliente()
    {
        return $this->belongsTo(Cliente::class);
    }

    public function venta()
    {
        return $this->belongsTo(Venta::class);
    }
    public function movimientos()
    {
        return $this->hasMany(DetCxc::class);
    }
}