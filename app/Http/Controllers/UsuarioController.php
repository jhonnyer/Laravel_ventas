<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests\UsuarioFormRequest;
use DB;

class UsuarioController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }
    // index crea el objeto request que es el archivo de verificacion principal
    public function index(Request $request){
        if($request)
        {
            // searchText es la variable de busqueda que esta guardada en la variable query del controlador 
            $query=trim($request->get('searchText'));
            // la variable usuarios hace una consulta en la tabla users de la base de datos 
            // campo name tiene cualquier cadena tanto al principio o al fin, por eso los comodides %$query %
            $usuarios=DB::table('users')->where('name','LIKE','%'.$query.'%')
            ->orderBy('id','desc')
            ->paginate(7);
            // Se crea nueva carpeta con un index 
            return view('seguridad.usuario.index',["usuarios"=>$usuarios,"searchText"=>$query]);
        }       
    }
    public function create(){
        return view("seguridad.usuario.create");
    }
    public function store(UsuarioFormRequest $request){
        // crear objeto usuario que hace referencia al modelo user 
        $usuario=new User;
        $usuario->name=$request->get('name');
        $usuario->email=$request->get('email');
        // password es encriptado y se envido lo del objeto usuario a la variable password 
        $usuario->password=bcrypt($request->get('password'));
        // guarda datos del objeto 
        $usuario->save();
        // redirecciona a la carpeta seguridad/usuario 
        return Redirect::to('seguridad/usuario');
    }
    public function edit($id){
        // retorna los datos filtrados del usuario a la carpeta id mediante el parametro con id 
        return view("seguridad.usuario.edit",["usuario"=>User::findOrFail($id)]);
    }
    public function update(UsuarioFormRequest $request, $id){
        $usuario=User::findOrFail($id);
        $usuario->name=$request->get('name');
        $usuario->email=$request->get('email');
        // password es encriptado y se envido lo del objeto usuario a la variable password 
        $usuario->password=bcrypt($request->get('password'));
        // guarda datos del objeto 
        $usuario->update();
        return Redirect::to('seguridad/usuario');
    }
    public function destroy($id){
        $usuario=DB::table('users')->where('id','=',$id)->delete();
        return Redirect::to('seguridad/usuario');
    }
}
