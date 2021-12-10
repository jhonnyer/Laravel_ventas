@extends('layouts.admin')
@section('contenido')
    <div class="row">
        <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
            <h3>Nueva categoría</h3>
            @if(count($errors)>0)
            <div class="alert alert-danger">
                <ul>
                @foreach($errors->all() as $error)
                    <li>{{$error}}</li>
                @endforeach
                </ul>
            </div>
            @endif
            <!-- Metodo POST llama a la funcion store  -->
            {!!Form::open(array('url'=>'almacen/categoria','method'=>'POST','autocomplete'=>'off'))!!}
            {{Form::token()}}            
            <div class="form-group">
                <!-- {!!Form::text('nombre')!!} -->
                <!-- {!!Form::label('nombre','Nombre',['class'=>'form-control'])!!} -->
                <label for="nombre">Nombre</label>
                <!-- name="nombre" es el objeto recibido en la categoria  -->
                <input type="text" name="nombre" class="form-control" placeholder="Nombre..."></input>
            </div>
            <div class="form-group">
                <label for="descipcion">Descripcion</label>
                <input type="text" name="descripcion" class="form-control" placeholder="Descripcion..."></input>
            </div>
            <div class="form-group">
                <button class="btn btn-primary" type="submit">Guardar</button>
                <button class="btn btn-danger" type="reset">Cancelar</button>
            </div>
            {!!Form::close()!!}
        </div>
    </div>
@endsection