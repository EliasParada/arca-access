<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetalleFactura extends Model
{
    use HasFactory;

    public $timestamps = false;
    public $incrementing = false;
    protected $table = 'detalle_factura';

    protected $fillable = [
        'factura',
        'producto',
        'cantidad',
    ];

    public function facturas()
    {
        return $this->belongsTo(Factura::class, 'factura', 'id');
    }

    public function productos()
    {
        return $this->belongsTo(Products::class, 'producto', 'id');
    }
}
