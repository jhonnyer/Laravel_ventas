<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Categoria extends Model
{
    // Tabla a modificar 
    protected $table='categoria';
    // Mencion llave primaria, idcategoria campo con el que realiza la busqueda el controlador 
    protected $primaryKey='idcategoria';
    // Las variables anteriores no se envian o modifican (timestamps=false)
    public $timestamps=false;
    protected $fillable=[
        'nombre',
        'descripcion',
        'condicion'
    ];
    // No se quiere que se asigne al modelo 
    protected $guarded=[

    ];
    // use HasFactory;
}
