<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kardex extends Model
{
    use HasFactory;

    protected $table = 'kardex';

    protected $fillable = [
        'inventario_id',
        'tipo',
        'fecha',
        'doc_relacionado',
        'cantidad',
        'costo'
    ];

    protected $casts = [
        'fecha' => 'date',
        'cantidad' => 'decimal:2',
        'costo' => 'decimal:2',
    ];

    public function inventario()
    {
        return $this->belongsTo(Inventario::class);
    }
}