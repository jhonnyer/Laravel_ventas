@extends('layouts.admin')
@section('contenido')
    <div class="row">
        <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
            <h3>Editar Proveedor:   <strong>{{$persona->nombre}}</strong></h3>
            @if(count($errors)>0)
            <div class="alert alert-danger">
                <ul>
                @foreach($errors->all() as $error)
                    <li>{{$error}}</li>
                @endforeach
                </ul>
            </div>
            @endif
        </div>
    </div>
            <!-- Envia metodo PATCH para actualizar, la ruta de update del controlador y el parametro IDcategoria  -->
            {!!Form::model($persona,['method'=>'PATCH','action'=>['App\Http\Controllers\ProveedorController@update',$persona->idpersona]])!!}
            {{Form::token()}}            
    <div class="row">
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
            <div class="form-group">
                    <!-- {!!Form::text('nombre')!!} -->
                    <!-- {!!Form::label('nombre','Nombre',['class'=>'form-control'])!!} -->
                    <label for="nombre">Nombre</label>
                    <!-- name="nombre" es el objeto recibido en la categoria  -->
                    <!-- Si el nombre no es validado lo debe volver  a mostrar  -->
                    <input type="text" name="nombre" required value="{{$persona->nombre}}" class="form-control" placeholder="Nombre..."></input>
            </div>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
            <div class="form-group">
                    <!-- {!!Form::text('nombre')!!} -->
                    <!-- {!!Form::label('nombre','Nombre',['class'=>'form-control'])!!} -->
                    <label for="direccion">Dirección</label>
                    <!-- name="nombre" es el objeto recibido en la categoria  -->
                    <!-- Si el nombre no es validado lo debe volver  a mostrar  -->
                    <input type="text" name="direccion" value="{{$persona->direccion}}" class="form-control" placeholder="Dirección..."></input>
            </div>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
            <div class="form-group">
                <label>Documento</label>
                <select name="tipo_documento" class="form-control">
                @if($persona->tipo_documento=="CC")
                    <option value="CC" selected>Cédula de ciudadania</option>
                    <option value="TI">Tarjeta de identidad</option>
                    <option value="PAS">Pasaporte</option>
                @elseif($persona->tipo_documento=="TI")
                    <option value="CC">Cédula de ciudadania</option>
                    <option value="TI" selected>Tarjeta de identidad</option>
                    <option value="PAS">Pasaporte</option>
                @else
                    <option value="CC">Cédula de ciudadania</option>
                    <option value="TI">Tarjeta de identidad</option>
                    <option value="PAS" selected>Pasaporte</option>
                </select>
                @endif
            </div>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
            <div class="form-group">
                    <label for="num_documento">Número de Documento</label>
                    <!-- name="codigo" es el objeto recibido en la categoria  -->
                    <!-- Si el codigo no es validado lo debe volver  a mostrar  -->
                    <input type="text" name="num_documento" value="{{$persona->num_documento}}" class="form-control" placeholder="Número del documento..."></input>
            </div>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
            <div class="form-group">
                    <label for="telefono">Teléfono</label>
                    <!-- name="codigo" es el objeto recibido en la categoria  -->
                    <!-- Si el codigo no es validado lo debe volver  a mostrar  -->
                    <input type="text" name="telefono" value="{{$persona->telefono}}" class="form-control" placeholder="Teléfono..."></input>
            </div>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
            <div class="form-group">
                    <label for="email">Correo Eléctronico</label>
                    <!-- name="codigo" es el objeto recibido en la categoria  -->
                    <!-- Si el codigo no es validado lo debe volver  a mostrar  -->
                    <input type="text" name="email" value="{{$persona->email}}" class="form-control" placeholder="Email..."></input>
            </div>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
            <div class="form-group">
                <button class="btn btn-primary" type="submit">Guardar</button>
                <button class="btn btn-danger" type="reset">Cancelar</button>
            </div>
        </div>
    </div>    
            {!!Form::close()!!}
@endsection