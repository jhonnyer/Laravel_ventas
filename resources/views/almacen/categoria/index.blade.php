@extends('layouts.admin')
@section('contenido')

    <div class="row">
        <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
            <h3>Listado de Categorías <a href="categoria/create"><button class="btn btn-success">Nuevo</button></a></h3>
            @include('almacen.categoria.search')
    </div>
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="table-responsive">
            <table class="table table-striped table-bordered table-condensed table-hover">
                <thead>
                    <th>Id</th>
                    <th>Nombre</th>
                    <th>Descripción</th>
                    <th>Opciones</th>
                </thead>
            @foreach($categorias as $cat)
            <tr>
                <td>{{$cat->idcategoria}}</td>
                <td>{{$cat->nombre}}</td>
                <td>{{$cat->descripcion}}</td>
                <td>
                    <a href="{{URL::action('App\Http\Controllers\CategoriaController@edit',$cat->idcategoria)}}"><button class="btn btn-info">Editar</button></a>
                    <!-- data-target permite llamar al id del modal de la vista creado, el formulario de eliminar  -->
                    <a href="" data-target="#modal-delete-{{$cat->idcategoria}}" data-toggle="modal"><button class="btn btn-danger">Eliminar</button></a>                    
                </td>
            </tr>
            @include('almacen.categoria.modal')
            @endforeach
            </table>
        </div>
        <!-- Render permite paginar  -->
        {{$categorias->render()}}
    </div>
@stop