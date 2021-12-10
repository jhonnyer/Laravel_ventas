<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ingreso extends Model
{
    protected $table='ingreso';
    // Mencion llave primaria, idcategoria campo con el que realiza la busqueda el controlador 
    protected $primaryKey='idingreso';
    // Las variables anteriores no se envian o modifican (timestamps=false)
    public $timestamps=false;
    protected $fillable=[
        'idproveedor',
        'tipo_comprobante',
        'serie_comprobante',
        'num_comprobante',
        'fecha_hora',
        'impuesto',
        'estado'
    ];
    // No se quiere que se asigne al modelo 
    protected $guarded=[

    ];
}
