<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Products extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $table = 'productos';

    protected $fillable = [
        'nombre',
        'descripcion',
        'proveedor',
        'fecha',
        'precio',   
        'imagen',
        'categoria',
    ];
}
