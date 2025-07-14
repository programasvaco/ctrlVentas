<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Caja extends Model
{
    use HasFactory;

    protected $table = 'caja';

    protected $fillable = [
        'tipo',
        'doc_relacionado',
        'fecha',
        'cantidad',
        'concepto',
        'corte_id'
    ];

    public function corte(): BelongsTo
    {
        return $this->belongsTo(CorteCaja::class, 'corte_id'); // o 'id_corte'
    }
    
    protected $casts = [
        'fecha' => 'date',
        'cantidad' => 'decimal:2',
    ];
}