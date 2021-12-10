<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetalleVenta extends Model
{
    protected $table='detalle_venta';
    // Mencion llave primaria, idcategoria campo con el que realiza la busqueda el controlador 
    protected $primaryKey='iddetalle_venta';
    // Las variables anteriores no se envian o modifican (timestamps=false)
    public $timestamps=false;
    protected $fillable=[
        'idventa',
        'idarticulo',
        'cantidad',
        'precio_venta',
        'descuento',
    ];
    // No se quiere que se asigne al modelo 
    protected $guarded=[

    ];
}
