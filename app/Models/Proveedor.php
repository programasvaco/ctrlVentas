<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Proveedor extends Model
{
    use HasFactory;

    protected $table = 'proveedores';

    protected $fillable = [
        'nombre',
        'domicilio',
        'ciudad',
        'saldo',
        'dias_plazo',
        'estado'        
    ];

    protected $casts = [
        'saldo' => 'decimal:2',
    ];
    public function cxp()
    {
        return $this->hasMany(Cxp::class);
    }
}
