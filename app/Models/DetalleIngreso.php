<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetalleIngreso extends Model
{
    protected $table='detalle_ingreso';
    // Mencion llave primaria, idcategoria campo con el que realiza la busqueda el controlador 
    protected $primaryKey='iddetalle_ingreso';
    // Las variables anteriores no se envian o modifican (timestamps=false)
    public $timestamps=false;
    protected $fillable=[
        'idingreso',
        'idarticulo',
        'cantidad',
        'precio_compra',
        'precio_venta',
    ];
    // No se quiere que se asigne al modelo 
    protected $guarded=[

    ];
}
