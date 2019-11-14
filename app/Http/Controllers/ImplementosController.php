<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;

use App\Implementos;

class ImplementosController extends Controller
{
    public function implementos(){

        $implementos=Implementos::table()
        ->groupBy('descripcion');

       // $implementos=Implementos::select('SELECT COUNT(id),descripcion FROM implementos GROUP BY descripcion')->get();        


        return response()->json([
             'code' => 200,
             'status'=> 'sucess',
             'implementos'=> $implementos
        ]);
     }

     public function verImplemento($implemento){

          $implementos=Implementos::where('descripcion',$implemento)->get();

          //recoger los datos del usurio por post
          $json = $implementos -> input('json', null);
          $param_array =json_decode($json,true);//array
   
          return response()->json([
               'code' => 200,
               'status'=> 'sucess',
               'implementos'=> $implementos
          ]);
       }
}


