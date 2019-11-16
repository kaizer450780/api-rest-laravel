<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;

use App\Implementos;

class ImplementosController extends Controller
{
    public function implementos(){
     //SELECT COUNT(id),descripcion FROM implementos GROUP BY descripcion
     
        $implementos=Implementos::all()->groupBy('llave');
        $param_array =json_decode($implementos,true);//array 
        $count=count($param_array);    


        for($i = 0; $i < $count; $i++){
             $array=$param_array[$i];
             $array2=$array[0];
             $auxcount=count($array);
             $array2 = array_add($array2, 'cantidad', $auxcount);
             $param_array[$i]=$array2;
            // se manejan 2 vectores aux para profundizar el param array, y luego se pone la info necesaria en el param
          
        }
        

        return response()->json([
             'code' => 200,
             'status'=> 'sucess',
             'implementos'=> $param_array
        ]);
     }

     public function verPrestamoImplemento($implemento){

          $reserva = Implementos::join("prestamo","implementos.id","=","prestamo.id_implementos")
        ->where('implementos.descripcion','=',$implemento)
        ->get(['implementos.id','implementos.placa','implementos.descripcion','prestamo.fecha_inicial','prestamo.fecha_final']);

          return response()->json([
               'code' => 200,
               'status'=> 'sucess',
               'implementos'=> $reserva
          ]);
       }
}


