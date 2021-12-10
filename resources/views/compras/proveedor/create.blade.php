@extends('layouts.admin')
@section('contenido')
    <div class="row">
        <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
            <h3>Nuevo Proveedor</h3>
            @if(count($errors)>0)
            <div class="alert alert-danger">
                <ul>
                @foreach($errors->all() as $error)
                    <li>{{$error}}</li>
                @endforeach
                </ul>
            @endif
            </div>
        </div>
    </div>
            <!-- Metodo POST llama a la funcion store  -->
            {!!Form::open(array('url'=>'compras/proveedor','method'=>'POST','autocomplete'=>'off'))!!}
            {{Form::token()}}
            <!-- LAs etiquetas se muestren en dos columnas  -->
    <div class="row">
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
            <div class="form-group">
                    <!-- {!!Form::text('nombre')!!} -->
                    <!-- {!!Form::label('nombre','Nombre',['class'=>'form-control'])!!} -->
                    <label for="nombre">Nombre</label>
                    <!-- name="nombre" es el objeto recibido en la categoria  -->
                    <!-- Si el nombre no es validado lo debe volver  a mostrar  -->
                    <input type="text" name="nombre" required value="{{old('nombre')}}" class="form-control" placeholder="Nombre..."></input>
            </div>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
            <div class="form-group">
                    <!-- {!!Form::text('nombre')!!} -->
                    <!-- {!!Form::label('nombre','Nombre',['class'=>'form-control'])!!} -->
                    <label for="direccion">Dirección</label>
                    <!-- name="nombre" es el objeto recibido en la categoria  -->
                    <!-- Si el nombre no es validado lo debe volver  a mostrar  -->
                    <input type="text" name="direccion" value="{{old('direccion')}}" class="form-control" placeholder="Dirección..."></input>
            </div>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
            <div class="form-group">
                <label>Documento</label>
                <select name="tipo_documento" class="form-control">
                    <option value="CC">Cédula de ciudadania</option>
                    <option value="TI">Tarjeta de identidad</option>
                    <option value="PAS">Pasaporte</option>
                </select>
            </div>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
            <div class="form-group">
                    <label for="num_documento">Número de Documento</label>
                    <!-- name="codigo" es el objeto recibido en la categoria  -->
                    <!-- Si el codigo no es validado lo debe volver  a mostrar  -->
                    <input type="text" name="num_documento" value="{{old('num_documento')}}" class="form-control" placeholder="Número del documento..."></input>
            </div>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
            <div class="form-group">
                    <label for="telefono">Teléfono</label>
                    <!-- name="codigo" es el objeto recibido en la categoria  -->
                    <!-- Si el codigo no es validado lo debe volver  a mostrar  -->
                    <input type="text" name="telefono" value="{{old('telefono')}}" class="form-control" placeholder="Teléfono..."></input>
            </div>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
            <div class="form-group">
                    <label for="email">Correo Eléctronico</label>
                    <!-- name="codigo" es el objeto recibido en la categoria  -->
                    <!-- Si el codigo no es validado lo debe volver  a mostrar  -->
                    <input type="text" name="email" value="{{old('email')}}" class="form-control" placeholder="Email..."></input>
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