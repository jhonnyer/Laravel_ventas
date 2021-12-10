<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
// Añadir metodos en el controlador  
use App\Models\Articulo;
use Illuminate\Support\Facades\Redirect;
// Subir imagenes desde el host utilizado por el cliente 
// Artchivo input no sirve, se utiliza el request para subir imagenes 
// use Illuminate\Support\Facades\Input;
// Archivo request restricciones modelo 
use App\Http\Requests\ArticuloFormRequest;
use DB;

class ArticuloController extends Controller
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
            // query variable que almacena el dato o campo que se quiere filtrar 
            $query=trim($request->get('searchText'));
            // Muestra las categorias cuyas condicion es igual a 1 en la base de datos 
            // la tabla articulo se le pone el alias a para filtrar los datos y relacionar con otra tabla 
            $articulos=DB::table('articulo as a')
            // Relacion con la tabla categoria mediante JOIN 
            // la tabla a.idarticulo se va a unir con la tabla c.idcategoria. Utilizacion llaves foraneas
            ->join('categoria as c','a.idcategoria','=','c.idcategoria')
            // c.nombre as categoria se renombra el campo nombre por categoria 
            ->select('a.idarticulo','a.nombre','a.codigo','a.stock','c.nombre as categoria','a.descripcion','a.imagen','a.estado')
            // Filtrar por el nombre del articulo, el nombre contenga la cadena del nombre a buscar en el index 
            ->where('a.nombre','LIKE','%'.$query.'%')
            // Filtra por codigo. Dos filtros utilizados 
            ->orwhere('a.codigo','LIKE','%'.$query.'%')
            ->orderBy('idarticulo','desc')
            ->paginate(7);
            return view('almacen.articulo.index',["articulos"=>$articulos,"searchText"=>$query]);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // Seleccionar todas las categorias donde la condicion sea igual a 1, no se hayan eliminado 
        $categorias=DB::table('categoria')->where('condicion','=','1')->get();
        // volvemos a la vista articulo/create y se envian todos los datos almacenados en categorias 
        return view("almacen.articulo.create",["categorias"=>$categorias]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ArticuloFormRequest $request)
    {
        $articulo=new Articulo;
        $articulo->idcategoria=$request->get('idcategoria');
        $articulo->codigo=$request->get('codigo');
        $articulo->nombre=$request->get('nombre');
        $articulo->stock=$request->get('stock');
        $articulo->descripcion=$request->get('descripcion');
        // Cuando se crea un articulo va  a estar en estado activo 
        $articulo->estado='Activo';
        // Input no sirve para subir imagenes, deshabilitado 
        // if(Input::hasFile('imagen')){
        //     $file=Input::file('imagen');
        //     // se mueve a la carpeta publica, directorio imagenes 
        //     $file->move(public_path().'/imagenes/articulos/',$file->getClientOriginalName());
        //     $articulo->imagen=$file->getClientOriginalName();
        // }
        if($archivo=$request->file('imagen')){
            //    Guardar en la variable nombre el nombre del archivo adjunto. Metodo getClientOriginalName  
               $nombre=$archivo->getClientOriginalName();
            //    Movel el nombre del archivo a la carpeta images 
               $archivo->move(public_path().'/imagenes/articulos/',$nombre); 
            //    Almacenar la imagen en la base de datos fotos, utilizar el modelo FOTO 
                $articulo->imagen=$archivo->getClientOriginalName();
        }
        $articulo->save();

        return Redirect::to('almacen/articulo');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return view("almacen.articulo.show",["articulo"=>Articulo::findOrFail($id)]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // Recibe un parametro id para poder seleccionar un articulo en especifico 
        $articulo=Articulo::findOrFail($id);
        // Filtrar las categorias por la condiccion 1, las que esten activas 
        $categorias=DB::table('categoria')->where('condicion','=','1')->get();
        return view("almacen.articulo.edit",["articulo"=>$articulo,"categorias"=>$categorias]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ArticuloFormRequest $request, $id)
    {
        $articulo=Articulo::FindOrFail($id);
        $articulo->nombre=$request->get('idcategoria');
        $articulo->codigo=$request->get('codigo');
        $articulo->nombre=$request->get('nombre');
        $articulo->stock=$request->get('stock');
        $articulo->descripcion=$request->get('descripcion');
        if($archivo=$request->file('imagen')){
            //    Guardar en la variable nombre el nombre del archivo adjunto. Metodo getClientOriginalName  
               $nombre=$archivo->getClientOriginalName();
            //    Movel el nombre del archivo a la carpeta images 
               $archivo->move(public_path().'/imagenes/articulos/',$nombre); 
            //    Almacenar la imagen en la base de datos fotos, utilizar el modelo FOTO 
                $articulo->imagen=$archivo->getClientOriginalName();
        }
        $articulo->update();
        return Redirect::to('almacen/articulo');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $articulo=Articulo::findOrFail($id);
        // Cuando se eliminar un producto en categoria cambia la condicion de activo a inactivo y en el index no se muestra 
        $articulo->estado='Inactivo';
        $articulo->update();
        return Redirect::to('almacen/articulo');
    }
    //
}
