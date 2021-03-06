@extends('layouts.admin')
@section('contenido')
    <div class="row">
        <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
            <h3>Nuevo Ingreso</h3>
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
            {!!Form::open(array('url'=>'compras/ingreso','method'=>'POST','autocomplete'=>'off'))!!}
            {{Form::token()}}
            <!-- LAs etiquetas se muestren en dos columnas  -->
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="form-group">
                    <!-- {!!Form::text('nombre')!!} -->
                    <!-- {!!Form::label('nombre','Nombre',['class'=>'form-control'])!!} -->
                    <label for="proveedor">Proveedor</label>
                    <select name="idproveedor" id="idproveedor" class="form_control selectpicker" data-live-search="true">
                    @foreach($personas as $persona)
                    <option value="{{$persona->idpersona}}">{{$persona->nombre}}</option>
                    @endforeach
                    </select>
            </div>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
            <div class="form-group">
                <label>Tipo Comprobante</label>
                <select name="tipo_comprobante" class="form-control">
                    <option value="Boleta">Boleta</option>
                    <option value="Factura">Factura</option>
                    <option value="Ticket">Ticket</option>
                </select>
            </div>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
            <div class="form-group">
                    <label for="serie_comprobante">Serie Comprobante</label>
                    <!-- name="codigo" es el obje|to recibido en la categoria  -->
                    <!-- Si el codigo no es validado lo debe volver  a mostrar  -->
                    <input type="text" name="serie_comprobante" value="{{old('serie_comprobante')}}" class="form-control" placeholder="Serie del comprobante..."></input>
            </div>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
            <div class="form-group">
                    <label for="num_comprobante">N??mero Comprobante</label>
                    <!-- name="codigo" es el obje|to recibido en la categoria  -->
                    <!-- Si el codigo no es validado lo debe volver  a mostrar  -->
                    <input type="text" name="num_comprobante" required value="{{old('num_comprobante')}}" class="form-control" placeholder="N??mero del comprobante..."></input>
            </div>
        </div>
    </div>
    <!-- Fila que encierra todo el detalle y los botones  -->
    <div class="row">
        <div class="panel panel-primary">
            <div class="panel-body">
                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                    <div class="for-group">
                        <label>Art??culo</label>
                        <!-- pidarticulo es un auxiliar que guarda temporalmente en el formulaario  -->
                        <select name="pidarticulo" class="form_control selectpicker" id="pidarticulo" data-live-search="true">
                        @foreach($articulos as $articulo)
                        <!-- articulo recibe el articulo del controller (select) -->
                        <option value="{{$articulo->idarticulo}}">{{$articulo->articulo}}</option>
                        @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                    <div class="form-group">
                        <label for="cantidad">Cantidad</label>
                        <input type="number" name="pcantidad" id="pcantidad" class="form-control"
                        placeholder="cantidad">
                    </div>
                </div>
                <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                    <div class="form-group">
                        <label for="precio_compra">Precio Compra</label>
                        <input type="number" name="pprecio_compra" id="pprecio_compra" class="form-control"
                        placeholder="P. Compra">
                    </div>
                </div>
                <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                    <div class="form-group">
                        <label for="precio_venta">Precio Venta</label>
                        <input type="number" name="pprecio_venta" id="pprecio_venta" class="form-control"
                        placeholder="P. Venta">
                    </div>
                </div>
                <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                    <div class="form-group">
                        <button type=button id="bt_add" class="btn btn-primary">Agregar</button>
                    </div>
                </div>
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <!-- identificador detaller permite verificar los campos de la tabla cuando se llame por medio de una funcion javascript  -->
                    <table id="detalles" class="table table-striped table-bordered table-condensed table-hover">
                        <thead style="background-color:#A9D0F5">
                            <th>Opciones</th>
                            <th>Art??culo</th>
                            <th>Cantidad</th>
                            <th>Precio Compra</th>
                            <th>Precio Venta</th>
                            <th>Subtotal</th>
                        </thead>
                        <tfoot>
                            <th>Total</th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <!-- id="total indica que el valor se va a actualizar dependiendo del total de ingreo " -->
                            <th><h4 id="total">$/. 0.00</h4></th>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12" id="guardar">
            <div class="form-group">
                <input name="_token" value="{{csrf_token()}}" type="hidden">
                <button class="btn btn-primary" type="submit">Guardar</button>
                <button class="btn btn-danger" type="reset">Cancelar</button>
            </div>
        </div>
    </div>            
        {!!Form::close()!!}
<!-- Insertar codigo javascript. Tener en cuenta nombre scripts fue el que se configuro archivo admin.blade.php @stack('scripts')  -->
@push('scripts')
<script>

    $(document).ready(function(){
        // cada que se haga click en el boton agregar con id bt_add, se llama a la funcion agregar 
        // y se envia a la tabla y los array respectivos en la DB 
        $('#bt_add').click(function(){
            agregar();
        });
    });

    // Funcion agregar 
    var cont=0;
    // Subtotal captura todos los subtotales de la linea de detalles 
    subtotal=[];
    // cuando cargue el documento al inicio el boton va a estar oculto
    $("#guardar").hide();
    function agregar()
    {
        // optiene los valores del formulario que esten seleccionados o a??adidos 
        idarticulo=$("#pidarticulo").val();
        // del pidarticulo recupera el texto que este seleccionado, tiene una seleccion. Obtiene el texto
        articulo=$("#pidarticulo option:selected").text();
        cantidad=$("#pcantidad").val();
        precio_compra=$("#pprecio_compra").val();
        precio_venta=$("#pprecio_venta").val();
        // cantidad diferente de vacio !=""
        // cantidad mayor que cero >0
        if (idarticulo!="" && cantidad!="" && cantidad>0 && precio_compra!="" && precio_venta!="")
        {
            subtotal[cont]=(cantidad*precio_compra);
            total=total+subtotal[cont];
            // td permite eliminar un detalle agregado 
            // contador va a empezar a acumular en fila para que luego permita eliminar 
            // Todo este comando se agrega en una sola linea, sino se debe concatenar 
            var fila='<tr class="selected" id="fila'+cont+'"><td><button type="button" class="btn btn-warning" onclick="eliminar('+cont+')">X</button></td><td><input type="hidden" name="idarticulo[]" value="'+idarticulo+'">'+articulo+'</td><td><input type="number" name="cantidad[]" value="'+cantidad+'"></td><td><input type="number" name="precio_compra[]" value="'+precio_compra+'"></td><td><input type="number" name="precio_venta[]" value="'+precio_venta+'"></td><td>'+subtotal[cont]+'</td></tr>';
            // indica que el contador se va acumulando cuantas veces se vaya agregando las filas 
            cont++;
            // llamo a la funcion limpiar, para limpiar el formulario
            limpiar();
            // identificador total del formulario create se actualiza con el nuevo valor almacenado en la variable total 
            $("#total").html("S/. " +total);
            // evalua si hay o un detalle para agregar,si no hay no muestra los botones
            evaluar();
            // voy a agregar la fila a la tabla 
            $("#detalles").append(fila);
        }
        else
        {
            alert("Error al ingresar los detalles del ingreso, revise los datos del articulo");
        }
    }
    // Funcion formulario detalles y boton guardar 
// variable total permite evaluar contenidos del detalle 
    total=0;
// funcion limpiar cajas de texto antes de que se envien al detalle en e formulaario 
// limpia el formulario el valor con un campo vacio. Se configura de acuerdo a los id en el formulario 
    function limpiar(){
        $("#pcantidad").val("");
        $("#pprecio_compra").val("");
        $("#pprecio_venta").val("");
    }
// Funcion evaluar si no hay un detalle en la tabla, se oculta los botones de guardar y cancelar 
    function evaluar(){
        // si total es mayor que cero, osea que hay detalles 
        if (total>0)
        {
            $("#guardar").show();
        }
        else
        {
            $("#guardar").hide();
        }
    }

    function eliminar(index){
        // por cada detalle se almacena un subtotal 
        // se resta el subtotal del total 
        total=total-subtotal[index];
        $("#total").html("$/. " +total);
        // del id de la fila agregada se va a eliminar 
        $("#fila" +index).remove();
        // evalua si el total es mayor que cero 
        evaluar();
    }
</script>
@endpush
@endsection

<!-- comando para crear trigger actualizacion db articulo, variable stock cuando se ingresa un detalle_ingreso  -->
<!-- DELIMITER // -->
<!-- create TRIGGER tr_udpStockIngreso AFTER INSERT ON detalle_ingreso -->
 <!-- FOR EACH ROW BEGIN -->
	<!-- UPDATE articulo SET stock = stock + NEW.cantidad -->
	<!-- WHERE articulo.idarticulo = NEW.idarticulo; -->
<!-- END -->
<!-- // -->
<!-- DELIMITER ;  -->