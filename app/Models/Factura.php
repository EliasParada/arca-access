<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Factura extends Model
{
    use HasFactory;

    protected $table = 'factura';

    protected $fillable = [
        'nombre',
        'usuario',
        'direccion',
        'total',
    ];

    public function detalles()
    {
        return $this->hasMany(DetalleFactura::class, 'factura', 'id');
    }

    public function usuarios()
    {
        return $this->belongsTo(User::class, 'usuario', 'id');
    }
}
