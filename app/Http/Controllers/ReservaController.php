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

    public function registrarReserva(Request $request){

                //recoger los datos del usurio por post
                $json = $request -> input('json', null);
                $param_array =json_decode($json,true);//array
                
                
                //$param_array= array_map('trim',$param_array);
                $count= count($param_array);
                for($i = 0; $i < $count; $i++){
                    

                    //validar datos
                    $validate = \Validator::make($param_array[$i],[
                        'fecha_inicial' => 'required',
                        'fecha_final'   => 'required',
                        'estado'  => 'required|alpha'
                    ]);
                    
                    $array = $param_array[$i];
                    

                    if($validate->fails()){
                        $data = array(
                            'status'    => 'error',
                            'code'      => 404,
                            'message'   => 'la reserva no se ha creado',
                            'errors'    => $validate->errors()
                        );
                        
                    }else{
                        //validacion correctamente
                            //crear el usuario
                            $reserva =new Reserva();
                            
                            $reserva->id_users= $array['id_users'];
                            $reserva->id_escenarios= $array['id_escenarios'];
                            $reserva->fecha_inicial= $array['fecha_inicial'];
                            $reserva->fecha_final=$array['fecha_final'];;
                            $reserva->estado= $array['estado'];
    
                            //insertar datos en la tabla users
                            $reserva->save();
            
                            $data = array(
                                'status'    => 'success',
                                'code'      => 200,
                                'message'   => 'la reserva se ha creado correctamente',
                                'reserva'=> 'reserva realizada'
                            );
                    }
                    
                }
                
                return response()->json($data,$data['code']); 
                
                
    }

    public function reservasPendientes($estado){

        $reserva = Reserva::join("escenarios","reserva.id_escenarios","=","escenarios.id")
        ->join("users","reserva.id_users","=","users.id_user")
        ->where('reserva.estado','=',$estado)
        ->get(['reserva.id','escenarios.nombre','escenarios.codigo', 'reserva.fecha_inicial','reserva.fecha_final','users.name','users.email']);


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

    public function actualizarReserva(Request $request){

        //recoger los datos del usurio por post
        $json = $request -> input('json', null);
        $param_array =json_decode($json,true);//array


        $reserva=Reserva::find($param_array['id']);
        $reserva->estado = $param_array['estado'];
        $reserva->save();



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
                'message'=>'error en el cambio de estado'
            );
        }

         return response()->json($data,$data['code']);
    }


}
