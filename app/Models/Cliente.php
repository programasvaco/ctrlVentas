<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre',
        'domicilio',
        'ciudad',
        'saldo',
        'estado'
    ];

    protected $casts = [
        'saldo' => 'decimal:2',
    ];
    public function ventas()
    {
        return $this->hasMany(Venta::class);
    }
    public function cuentasPorCobrar()
    {
        return $this->hasMany(Cxc::class);
    }
}