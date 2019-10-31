<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;

use App\Reserva;

class ReservaController extends Controller
{
    public function reservas($id){
        //print($id); die();
        $reserva=Reserva::where('id_escenarios',$id) -> get();

        if(is_object($reserva)){

            $data=array(
                'code'=> 200,
                'status'=>'sucess',
                'reserva'=>$reserva
            );
        }else{
            $data=array(
                'code'=> 400,
                'status'=>'error',
                'message'=>'el escenario no tiene reservas'
            );
        }

         return response()->json($data,$data['code']);
    }

}
