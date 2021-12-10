@extends('layouts.admin')
@section('contenido')
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="form-group">
                    <!-- {!!Form::text('nombre')!!} -->
                    <!-- {!!Form::label('nombre','Nombre',['class'=>'form-control'])!!} -->
                    <label for="cliente">Cliente</label>
                    <p>{{$venta->nombre}}</p>
                </div>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
            <div class="form-group">
                <label>Tipo Comprobante</label>
                <p>{{$venta->tipo_comprobante}}</p>
            </div>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
            <div class="form-group">
                <label for="serie_comprobante">Serie Comprobante</label>
                <p>{{$venta->serie_comprobante}}</p>
            </div>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
            <div class="form-group">
                <label for="num_comprobante">Número Comprobante</label>
                <p>{{$venta->num_comprobante}}</p>    
            </div>
        </div>
    </div>
    <!-- Fila que encierra todo el detalle y los botones  -->
    <div class="row">
        <div class="panel panel-primary">
            <div class="panel-body">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <!-- identificador detaller permite verificar los campos de la tabla cuando se llame por medio de una funcion javascript  -->
                    <table id="detalles" class="table table-striped table-bordered table-condensed table-hover">
                        <thead style="background-color:#A9D0F5">
                            <th>Artículo</th>
                            <th>Cantidad</th>
                            <th>Precio Venta</th>
                            <th>Descuento</th>
                            <th>Subtotal</th>
                        </thead>
                        <tfoot>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <!-- id="total indica que el valor se va a actualizar dependiendo del total de ingreo " -->
                            <!-- variable $venta->total, variable de calculo configurada en la funcion venta del select  -->
                            <!-- total acumula el valor de la cantidad multiplicada por el precio de compra  -->
                            <th><h4 id="total">{{$venta->total_venta}}</h4></th>
                        </tfoot>
                        <tbody>
                        @foreach($detalles as $det)
                        <tr>
                            <td>{{$det->articulo}}</td>
                            <td>{{$det->cantidad}}</td>
                            <td>{{$det->precio_venta}}</td>
                            <td>{{$det->descuento}}</td>
                            <td>{{$det->cantidad*$det->precio_venta-$det->descuento}}</td>
                        </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>            

@endsection
