<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Articulo extends Model
{
    // Tabla a modificar 
    protected $table='articulo';
    // Mencion llave primaria, idcategoria campo con el que realiza la busqueda el controlador 
    protected $primaryKey='idarticulo';
    // Las variables anteriores no se envian o modifican (timestamps=false)
    public $timestamps=false;
    protected $fillable=[
        'idcategoria',
        'codigo',
        'nombre',
        'stock',
        'descripcion',
        'imagen',
        'estado'
    ];
    // No se quiere que se asigne al modelo 
    protected $guarded=[

    ];
}
