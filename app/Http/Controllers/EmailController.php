<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Mail;
use App\Reserva;

class EmailController extends Controller
{
    public function contact(Request $request){

         //recoger los datos del usurio por post
         $json = $request -> input('json', null);
         $param_array =json_decode($json,true);//array

         $estado=$param_array['estado'];
         $id= $param_array['id'];

        $reserva = Reserva::join("escenarios","reserva.id_escenarios","=","escenarios.id")
        ->join("users","reserva.id_users","=","users.id_user")
        ->where('reserva.estado','=',$estado)
        ->where('reserva.id','=',$id)
        ->get(['reserva.id','escenarios.nombre','escenarios.codigo', 'reserva.fecha_inicial','reserva.fecha_final','reserva.estado','users.name','users.email']);

        return response()->json($reserva);

        $subject = "notificacion reserva de escenarios";
        $for = "correo_que_recibira_el_mensaje@gmail.com";
        Mail::send('email',$reserva->all(), function($msj) use($subject,$for){
            $msj->from("tucorreo@gmail.com","NombreQueApareceráComoEmisor");
            $msj->subject($subject);
            $msj->to($for);
        });
        return redirect()->back();
    }
}
