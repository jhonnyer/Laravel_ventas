<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Persona;
use Illuminate\Support\Facades\Redirect;
use PDF;
use DB;


class PDFController extends Controller
{
    public function imprimir(){
        // $persona=Persona::get();
        // $personas=DB::table('persona')->where('tipo_persona','=','Cliente')->get();
        // $persona=DB::table('persona');
        // $pdf = App::make('dompdf.wrapper');
        // $pdf->loadView('ventas/cliente/imprimir');
        // $pdf=PDF::loadView('ventas/cliente/imprimir');
        // $pdf->save(storage_path().'filename.pdf');
        // return $pdf->download('ventas/cliente/imprimir');

        // Mostrar en una ventana 
        return PDF::loadView('ventas/cliente/imprimir')
            ->stream('archivo.pdf');
    
    // public function imprimir(Request $request)
    // {
         // inicializa dompdf 
        // $pdf = App::make('dompdf.wrapper');
        // $pdf->loadHTML('<h1>Test</h1>');
        // return $pdf->stream();

        // // Tambien se puede
    //     $pdf=PDF::loadHTML('<h1 style="color:red">jhonnyer</h1> 
    //     <table class="table table-striped table-bordered table-condensed table-hover">
    //     <thead>
    //         <th>Nombre</th>
    //         <th>Telefono</th>
    //         <th>Email</th>
    //     </thead>
    //     @foreach($personas as $per)
    //     <tr>
    //         <td>{{$per->nombre}}</td>
    //         <td>{{$per->telefono}}</td>
    //         <td>{{$per->email}}</td>
    //     </tr>
    //     @endforeach
    //     </table>
    //     </div>
    //     {{$personas->render()}}
    // </div>
    //     ',$personas);

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
    //
}
