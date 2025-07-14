<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetCxp extends Model
{
    use HasFactory;

    protected $table = 'det_cxp';

    protected $fillable = [
        'cxp_id',
        'fecha_pago',
        'importe',
        'tipo',
        'observaciones'
    ];

    protected $casts = [
        'fecha_pago' => 'date',
        'importe' => 'decimal:2',
    ];

    public function cxp()
    {
        return $this->belongsTo(Cxp::class);
    }
}