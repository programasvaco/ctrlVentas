<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetCxc extends Model
{
    use HasFactory;

    protected $table = 'det_cxc';

    protected $fillable = [
        'cxc_id',
        'fecha_pago',
        'importe',
        'tipo',
        'observaciones'
    ];

    protected $casts = [
        'fecha_pago' => 'date',
        'importe' => 'decimal:2',
    ];

    public function cxc()
    {
        return $this->belongsTo(Cxc::class);
    }
}