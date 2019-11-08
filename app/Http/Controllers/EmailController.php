<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Reserva;
use Illuminate\Support\Facades\Mail;

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

        //se extrae el correo de la consulta a la base de datos
        $array_correo =json_decode($reserva,true);//array
        $aux= $array_correo[0];
        $correo= $aux['email'];

        //datos y envio del correo electronico
        $subject = "notificacion reserva de escenarios";
        $for = $correo;
        Mail::send('email.correo',$aux, function($msj) use($subject,$for){
            $msj->from("kaizer450450@gmail.com","Reservas Poli");
            $msj->subject($subject);
            $msj->to($for);
        });
        return $data = array(
            'status'    => 'success',
            'code'      => 200,
            'message'   => 'el correo fue enviado correctamente'
        );;
    }
}
