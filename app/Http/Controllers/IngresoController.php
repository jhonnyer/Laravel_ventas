<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ingreso;
use App\Models\DetalleIngreso;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests\IngresoFormRequest;
use DB;

// Carbon permite agregar el formato de fecha y hora 
use Carbon\Carbon;
use Response;
use Illuminate\Support\Collection;

class IngresoController extends Controller
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
            $ingresos=DB::table('ingreso as i')
            // idproveedor tiene que ser igual al idpersona (UNION DE AMBAS TABLAS)
            ->join('persona as p','i.idproveedor','=','p.idpersona')
            // Union detalle de ingreso, llave forarea di.idingreso 
            ->join('detalle_ingreso as di','i.idingreso','=','di.idingreso')
            // Busqueda variables y calculo valor total con variables cantidad y precio de venta
            // Metodo raw permite realizar operaciones, en este caso por cada detalle de ingreso cantidad se multiplica por el precio de compra y se almacena en un campo total que es sumado con la funcion sum
            ->select('i.idingreso','i.fecha_hora','p.nombre','i.tipo_comprobante','i.serie_comprobante','i.num_comprobante','i.impuesto','i.estado',DB::raw('sum(di.cantidad*precio_compra) as total'))
            // Like permite buscar al inicio o final de la tabla de datos 
            // Busqueda por el num_comprobante 
            ->where('i.num_comprobante','LIKE','%'.$query.'%')
            ->orderBy('i.idingreso','desc')
            // Agrupar todos los campos, menos la operacion de suma 
            ->groupBy('i.idingreso','i.fecha_hora','p.nombre','i.tipo_comprobante','i.serie_comprobante','i.num_comprobante','i.impuesto','i.estado')
            ->paginate(7);
            return view('compras.ingreso.index',["ingresos"=>$ingresos,"searchText"=>$query]);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // Mostrar todos los proveedores, por eso la variable persona 
        $personas=DB::table('persona')->where('tipo_persona','=','Proveedor')->get();
        // art es el alias de articulo 
        $articulos=DB::table('articulo as art')
        // Concatenar codigo articulo con el nombre del articulo mostrada en una sola columna y se le coloca un alias llamado as Articulo
        // Muestro una columna cuyo encabezado esta agrupado en articulo 
        // El que se almacena en la base de datos es el idarticulo    
            ->select(DB::raw('CONCAT(art.codigo,"",art.nombre) AS articulo'),'art.idarticulo')
            ->where('art.estado','=','Activo')
            ->get();
            // Envio los proveedores guardado en variable persona y articulos en variable articulos 
            return view("compras.ingreso.create",["personas"=>$personas,"articulos"=>$articulos]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(IngresoFormRequest $request)
    {
        // Esta funcion permite almacenar detalle ingreso e ingresos 
        // try es un capturador de excepciones, verificar problemas en la red, trabajar con transacciones 
        try{
            // Inicio transaccion 
            DB::beginTransaction();
            // Crear un objeto que hace referencia al modelo objeto 
            $ingreso=new Ingreso;
            $ingreso->idproveedor=$request->get('idproveedor');
            $ingreso->tipo_comprobante=$request->get('tipo_comprobante');
            $ingreso->serie_comprobante=$request->get('serie_comprobante');
            $ingreso->num_comprobante=$request->get('num_comprobante');
            // clase carbon optiene la fecha actual dependiendo la zona horaria 
            $mytime=Carbon::now('America/Bogota');
            // da formato a la fecha de acuerdo a la fecha actual 
            $ingreso->fecha_hora=$mytime->toDateTimeString();
            $ingreso->impuesto='18';
            $ingreso->estado='A';
            // guarda array ingreso en el modelo ingreso 
            $ingreso->save();
            // Array de detalles 
            $idarticulo=$request->get('idarticulo');
            $cantidad=$request->get('cantidad');
            $precio_compra=$request->get('precio_compra');
            $precio_venta=$request->get('precio_venta');
            // Contador para recorrer el array de detalles desde la posicion 0
            // Enviado desde el formulario registro de ingreso 
            $cont=0;
            // Recorre el contador 
            while($cont < count($idarticulo)){
                $detalle=new DetalleIngreso();
                // idingreso autogenerado se le pasa a la table detalle de ingreso 
                $detalle->idingreso=$ingreso->idingreso;
                // se pasa el detalle que este guardado en la pocision del contador cont 
                $detalle->idarticulo=$idarticulo[$cont];
                $detalle->cantidad=$cantidad[$cont];
                $detalle->precio_compra=$precio_compra[$cont];
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
        return Redirect::to('compras/ingreso');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $ingreso=DB::table('ingreso as i')
            // idproveedor tiene que ser igual al idpersona (UNION DE AMBAS TABLAS)
            ->join('persona as p','i.idproveedor','=','p.idpersona')
            // Union detalle de ingreso, llave forarea di.idingreso 
            ->join('detalle_ingreso as di','i.idingreso','=','di.idingreso')
            // Busqueda variables y calculo valor total con variables cantidad y precio de venta
            // Metodo raw permite realizar operaciones, en este caso por cada detalle de ingreso cantidad se multiplica por el precio de compra y se almacena en un campo total que es sumado con la funcion sum
            ->select('i.idingreso','i.fecha_hora','p.nombre','i.tipo_comprobante','i.serie_comprobante','i.num_comprobante','i.impuesto','i.estado',DB::raw('sum(di.cantidad*precio_compra) as total'))
            ->groupBy('i.idingreso')
            // filtrado por la variable id del ingreso 
            ->where('i.idingreso','=',$id)
            // funcion first muestra el id del primer ingreso 
            ->first();
        $detalles=DB::table('detalle_ingreso as d')
            // Unir articulo y detalle ingreso mediante los id
            ->join('articulo as a','d.idarticulo','=','a.idarticulo')
            // Seleccionar solamente unos detalles definidos en el select 
            ->select('a.nombre as articulo','d.cantidad','d.precio_compra','d.precio_venta')
            // detalle de idingreso solamente sea igual al id que se esta recibiendo 
            ->where('d.idingreso','=',$id)
            // Metodo get se obtiene todos los detalles 
            ->get();
            // Retorno a la vista enviando datos de la variable ingreso y detalles. Datos que envia
            return view("compras.ingreso.show",["ingreso"=>$ingreso,"detalles"=>$detalles]);
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
        $ingreso=Ingreso::findOrFail($id);
        // Cuando se eliminar un producto en categoria cambia la condicion de 1 a 0 y en el index no se muestra 
        $ingreso->Estado='C';
        $ingreso->update();
        return Redirect::to('compras/ingreso');
    }
}



// Consulta base de datos 
// SELECT p.nombre, di.cantidad, di.precio_compra FROM persona p, ingreso i, detalle_ingreso di where p.idpersona=i.idproveedor and di.idingreso=i.idingreso
// SELECT p.nombre, di.cantidad, di.precio_compra, di.cantidad*di.precio_compra FROM persona p, ingreso i, detalle_ingreso di where p.idpersona=i.idproveedor and di.idingreso=i.idingreso