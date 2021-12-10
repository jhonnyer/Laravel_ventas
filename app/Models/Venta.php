<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Venta extends Model
{
    protected $table='venta';
    // Mencion llave primaria, idcategoria campo con el que realiza la busqueda el controlador 
    protected $primaryKey='idventa';
    // Las variables anteriores no se envian o modifican (timestamps=false)
    public $timestamps=false;
    protected $fillable=[
        'idcliente',
        'tipo_comprobante',
        'serie_comprobante',
        'num_comprobante',
        'fecha_hora',
        'impuesto',
        'total_venta',
        'estado'
    ];
    // No se quiere que se asigne al modelo 
    protected $guarded=[

    ];
}
