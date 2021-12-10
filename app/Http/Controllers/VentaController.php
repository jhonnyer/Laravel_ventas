<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Venta;
use App\Models\DetalleVenta;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests\VentaFormRequest;
use DB;
use App;
use PDF;

use Carbon\Carbon;
use Response;
use Illuminate\Support\Collection;

class VentaController extends Controller
{
   /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct(){
        // Se gestione el acceso por usuario 
        $this->middleware('auth');
    }
    public function index(Request $request)
    {
        if($request){
            // texto de busqueda para filtrar todas las categorias 
            $query=trim($request->get('searchText'));
            // Muestra las categorias cuyas condicion es igual a 1 en la base de datos 
            $ventas=DB::table('venta as v')
            // idproveedor tiene que ser igual al idpersona (UNION DE AMBAS TABLAS)
            ->join('persona as p','v.idcliente','=','p.idpersona')
            // Union detalle de ingreso, llave forarea di.idingreso 
            ->join('detalle_venta as dv','v.idventa','=','dv.idventa')
            // Busqueda variables y calculo valor total con variables cantidad y precio de venta
            // Metodo raw permite realizar operaciones, en este caso por cada detalle de ingreso cantidad se multiplica por el precio de compra y se almacena en un campo total que es sumado con la funcion sum
            ->select('v.idventa','v.fecha_hora','p.nombre','v.tipo_comprobante','v.serie_comprobante','v.num_comprobante','v.impuesto','v.estado','v.total_venta')
            // Like permite buscar al inicio o final de la tabla de datos 
            // Busqueda por el num_comprobante 
            ->where('v.num_comprobante','LIKE','%'.$query.'%')
            ->orderBy('v.idventa','desc')
            // Agrupar todos los campos, menos la operacion de suma 
            ->groupBy('v.idventa','v.fecha_hora','p.nombre','v.tipo_comprobante','v.serie_comprobante','v.num_comprobante','v.impuesto','v.estado')
            ->paginate(7);
            return view('ventas.venta.index',["ventas"=>$ventas,"searchText"=>$query]);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // Mostrar todos los clientes, por eso la variable persona 
        $personas=DB::table('persona')->where('tipo_persona','=','Cliente')->get();
        // art es el alias de articulo 
        $articulos=DB::table('articulo as art')
        ->join('detalle_ingreso as di','art.idarticulo','=','di.idarticulo')
        // Concatenar codigo articulo con el nombre del articulo mostrada en una sola columna y se le coloca un alias llamado as Articulo
        // Muestro una columna cuyo encabezado esta agrupado en articulo 
        // El que se almacena en la bas0e de datos es el idarticulo    
        // Se calcula el precio promedio del precio de venta 
            ->select(DB::raw('CONCAT(art.codigo,"",art.nombre) AS articulo'),'art.idarticulo','art.stock',DB::raw('avg(di.precio_venta) as precio_promedio'))
            ->where('art.estado','=','Activo')
            ->where('art.stock','>','0')
            // agrupamiento de variables de varias tablas 
            ->groupBy('articulo','art.idarticulo','art.stock')
            ->get();
            // Envio los proveedores guardado en variable persona y articulos en variable articulos 
            return view("ventas.venta.create",["personas"=>$personas,"articulos"=>$articulos]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(VentaFormRequest $request)
    {
        // Esta funcion permite almacenar detalle ingreso e ingresos 
        // try es un capturador de excepciones, verificar problemas en la red, trabajar con transacciones 
        try{
            // Inicio transaccion 
            DB::beginTransaction();
            // Crear un objeto que hace referencia al modelo objeto 
            $venta=new Venta;
            $venta->idcliente=$request->get('idcliente');
            $venta->tipo_comprobante=$request->get('tipo_comprobante');
            $venta->serie_comprobante=$request->get('serie_comprobante');
            $venta->num_comprobante=$request->get('num_comprobante');
            $venta->total_venta=$request->get('total_venta');
            // clase carbon optiene la fecha actual dependiendo la zona horaria 
            $mytime=Carbon::now('America/Bogota');
            // da formato a la fecha de acuerdo a la fecha actual 
            $venta->fecha_hora=$mytime->toDateTimeString();
            $venta->impuesto='18';
            $venta->estado='A';
            // guarda array ingreso en el modelo ingreso 
            $venta->save();
            // Array de detalles 
            $idarticulo=$request->get('idarticulo');
            $cantidad=$request->get('cantidad');
            $descuento=$request->get('descuento');
            $precio_venta=$request->get('precio_venta');
            // Contador para recorrer el array de detalles desde la posicion 0
            // Enviado desde el formulario registro de ingreso 
            $cont=0;
            // Recorre el contador 
            while($cont < count($idarticulo)){
                $detalle=new DetalleVenta();
                // idingreso autogenerado se le pasa a la table detalle de ingreso 
                $detalle->idventa=$venta->idventa;
                // se pasa el detalle que este guardado en la pocision del contador cont 
                $detalle->idarticulo=$idarticulo[$cont];
                $detalle->cantidad=$cantidad[$cont];
                $detalle->descuento=$descuento[$cont];
                $detalle->precio_venta=$precio_venta[$cont];
                $detalle->save();

                $cont=$cont+1;
            }
            // Termina la transaccion 
            DB::commit();
        }catch(\Exception $e){
            // Si hay un error en la red, cancela la transaccion 
            DB::rollback();
        }
        return Redirect::to('ventas/venta');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $venta=DB::table('venta as v')
            // idproveedor tiene que ser igual al idpersona (UNION DE AMBAS TABLAS)
            ->join('persona as p','v.idcliente','=','p.idpersona')
            // Union detalle de ingreso, llave forarea di.idingreso 
            ->join('detalle_venta as dv','v.idventa','=','dv.idventa')
            // Busqueda variables y calculo valor total con variables cantidad y precio de venta
            // Metodo raw permite realizar operaciones, en este caso por cada detalle de ingreso cantidad se multiplica por el precio de compra y se almacena en un campo total que es sumado con la funcion sum
            ->select('v.idventa','v.fecha_hora','p.nombre','v.tipo_comprobante','v.serie_comprobante','v.num_comprobante','v.impuesto','v.estado','v.total_venta')
            // ->groupBy('v.idventa')
            // filtrado por la variable id del ingreso 
            ->where('v.idventa','=',$id)
            // ->groupBy('idventa','total_venta','idcliente','idpersona')
            // funcion first muestra el id del primer ingreso 
            ->first();
        $detalles=DB::table('detalle_venta as d')
            // Unir articulo y detalle ingreso mediante los id
            ->join('articulo as a','d.idarticulo','=','a.idarticulo')
            // Seleccionar solamente unos detalles definidos en el select 
            ->select('a.nombre as articulo','d.cantidad','d.descuento','d.precio_venta')
            // detalle de idingreso solamente sea igual al id que se esta recibiendo 
            ->where('d.idventa','=',$id)
            // Metodo get se obtiene todos los detalles 
            ->get();
            // Retorno a la vista enviando datos de la variable ingreso y detalles. Datos que envia
            return view("ventas.venta.show",["venta"=>$venta,"detalles"=>$detalles]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(PersonaFormRequest $request, $id)
    {
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // Coincida unicamente con el id que se quiere cambiar de estado 
        $venta=Venta::findOrFail($id);
        // Cuando se eliminar un producto en categoria cambia la condicion de 1 a 0 y en el index no se muestra 
        $venta->Estado='C';
        $venta->update();
        return Redirect::to('ventas/venta');
    }
    public function imprimir(Request $request)
    {
         // inicializa dompdf 
        // $pdf = App::make('dompdf.wrapper');
        // $pdf->loadHTML('<h1>Test</h1>');
        // return $pdf->stream();

        // // Tambien se puede
        // $pdf=PDF::loadHTML('<h1 style="color:red">jhonnyer</h1>');

        // Carga una vista 
        // $pdf=PDF::loadView('imprimir');
        // // Returna lo guardado en pdf en el navegador
        // return $pdf->stream();
        // // El pdf se descarga al llamar la pagina.
        // // return $pdf->download();
        // $pdf = \PDF::loadView('ventas.venta.imprimir');
        // return $pdf->stream();
        // return $pdf->download('imprimir.pdf');
    }
}
