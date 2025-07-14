<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Articulo extends Model
{
    use HasFactory;

    protected $fillable = [
        'articulo',
        'unidad',
        'estado',
        'imagen'
    ];

    public function inventarios()
    {
        return $this->hasMany(Inventario::class);
    }
}