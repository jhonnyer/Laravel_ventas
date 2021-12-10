@extends('layouts.admin')
@section('contenido')
    <div class="row">
        <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
            <h3>Editar Artículo:   <strong>{{$articulo->nombre}}</strong></h3>
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
            {!!Form::model($articulo,['method'=>'PATCH','action'=>['App\Http\Controllers\ArticuloController@update',$articulo->idarticulo],'files'=>'true'])!!}
            {{Form::token()}}            
    <div class="row">
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
            <div class="form-group">
                    <!-- {!!Form::text('nombre')!!} -->
                    <!-- {!!Form::label('nombre','Nombre',['class'=>'form-control'])!!} -->
                    <label for="nombre">Nombre</label>
                    <!-- name="nombre" es el objeto recibido en la categoria  -->
                    <!-- Si el nombre no es validado lo debe volver  a mostrar  -->
                    <input type="text" name="nombre" required value="{{$articulo->nombre}}" class="form-control"></input>
            </div>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
            <div class="form-group">
                <label>Categoría</label>
                <select name="idcategoria" class="form-control">
                    @foreach($categorias as $cat)
                    <!-- Si categoria es igual al id de articulo, va a estar seleccionada -->
                    @if($cat->idcategoria==$articulo->idcategoria)
                        <option value="{{$cat->idcategoria}}" selected>{{$cat->nombre}}</option>
                    @else
                    <!-- Sino no la muestra seleccionada  -->
                        <option value="{{$cat->idcategoria}}">{{$cat->nombre}}</option>
                    @endif
                    @endforeach
                </select>
            </div>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
            <div class="form-group">
                    <label for="codigo">Código</label>
                    <!-- name="codigo" es el objeto recibido en la categoria  -->
                    <!-- Si el codigo no es validado lo debe volver  a mostrar  -->
                    <input type="text" name="codigo" required value="{{$articulo->codigo}}" class="form-control"></input>
            </div>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
            <div class="form-group">
                    <label for="stock">Stock</label>
                    <!-- name="codigo" es el objeto recibido en la categoria  -->
                    <!-- Si el codigo no es validado lo debe volver  a mostrar  -->
                    <input type="text" name="stock" required value="{{$articulo->stock}}" class="form-control"></input>
            </div>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
            <div class="form-group">
                    <label for="descripcion">Descripción</label>
                    <!-- name="codigo" es el objeto recibido en la categoria  -->
                    <!-- Si el codigo no es validado lo debe volver  a mostrar  -->
                    <input type="text" name="descripcion" value="{{$articulo->descripcion}}" class="form-control" placeholder="Descripción del artículo..."></input>
            </div>
        </div>

        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
            <div class="form-group">
                    <label for="imagen">Imágen</label>
                    <!-- name="codigo" es el objeto recibido en la categoria  -->
                    <!-- Si el codigo no es validado lo debe volver  a mostrar  -->
                    <input type="file" name="imagen" class="form-control"></input>
                    <!-- Si imagen del articulo es diferente de vacio, hay una ruta de la imagen ya establecida  -->
                    @if(($articulo->imagen)!="")
                        <img src="{{asset('imagenes/articulos/'.$articulo->imagen)}}" height="300px" width="300px">
                    @endif
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