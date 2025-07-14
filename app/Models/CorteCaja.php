<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CorteCaja extends Model
{
    protected $table = 'cortes_caja';

    protected $fillable = [
        'fecha_inicio',
        'fecha_fin',
        'total_entradas',
        'total_salidas',
        'saldo_final',
        'notas'
    ];

    public function movimientos(): HasMany
    {
        return $this->hasMany(Caja::class, 'corte_id'); // o 'id_corte' si ese es el nombre real
    }
}
