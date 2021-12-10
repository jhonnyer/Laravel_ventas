<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Persona extends Model
{
    protected $table='persona';
    // Mencion llave primaria, idcategoria campo con el que realiza la busqueda el controlador 
    protected $primaryKey='idpersona';
    // Las variables anteriores no se envian o modifican (timestamps=false)
    public $timestamps=false;
    protected $fillable=[
        'tipo_persona',
        'nombre',
        'tipo_documento',
        'num_documento',
        'direccion',
        'telefono',
        'email'
    ];
    // No se quiere que se asigne al modelo 
    protected $guarded=[

    ];
}
