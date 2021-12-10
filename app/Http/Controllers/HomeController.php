<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(){
        // Se gestione el acceso por usuario 
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }
    // public function imprimir(){
    //     //     // inicializa dompdf 
    //     // $pdf = App::make('dompdf.wrapper');
    //     // $pdf->loadHTML('<h1>Test</h1>');

    //     // // Tambien se puede
    //     $pdf=PDF::loadHTML('<h1 style="color:red">Test</h1>');

    //     // Carga una vista 
    //     // $pdf=PDF::loadView('imprimir');
    //     // // Returna lo guardado en pdf en el navegador
    //     // return $pdf->stream();
    //     // // El pdf se descarga al llamar la pagina.
    //     // // return $pdf->download();
    //     // $pdf = \PDF::loadView('welcome');
    //     // return $pdf->stream();
    //     return $pdf->download('imprimir.pdf');
    // }
}
