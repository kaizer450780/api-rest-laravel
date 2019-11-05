<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;

use App\Implementos;

class ImplementosController extends Controller
{
    public function index(){
        $implementos=Implementos::all();
 
        return response()->json([
             'code' => 200,
             'status'=> 'sucess',
             'escenarios'=> $implementos
        ]);
     }
}


