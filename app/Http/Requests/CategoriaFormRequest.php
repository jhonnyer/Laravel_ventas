<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CategoriaFormRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        // Esta autorizado para hacer el request el usuario
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            // Datos del formulario a validar, nombre y descripcion deben ser requeridos 
            // con un maximo de 50 y 256 caracteres
            'nombre'=>'required|max:50',
            'descripcion'=>'max:256',
            //
        ];
    }
}
